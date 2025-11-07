<?php

namespace App\Http\Controllers;

use App\Models\RouletteLog;
use App\Models\RouletteItem;
use App\Models\RouletteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouletteController extends Controller
{
    // Página principal da roleta
    public function index()
    {
        \Log::info('Roulette index accessed', [
            'user_id' => session('user_id'),
            'email' => session('email')
        ]);

        if (!session('user_id')) {
            \Log::warning('User not logged in, redirecting to account');
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        // Verificar se a roleta está ativa
        if (!RouletteSetting::isActive()) {
            return redirect('/account')->with('message', 'A roleta está temporariamente desativada.')
                ->with('message_type', 'error');
        }

        $userId = session('user_id');
        $userEmail = session('email');
        
        // Buscar account_id da tabela login usando o email
        $loginAccount = DB::connection('ragnarok')->table('login')
            ->where('email', $userEmail)
            ->first();
        
        \Log::info('Login account search', [
            'email' => $userEmail, 
            'found' => $loginAccount ? 'yes' : 'no',
            'account_id' => $loginAccount ? $loginAccount->account_id : null
        ]);
        
        if (!$loginAccount) {
            \Log::error('Login account not found', ['email' => $userEmail]);
            return redirect('/account')->with('message', 'Você precisa criar uma conta de jogo primeiro.')
                ->with('message_type', 'error');
        }

        $account_id = $loginAccount->account_id;
        
        // Obter saldo de CASH POINTS do banco ragnarok
        $cash_points = $this->getCashPoints($account_id);
        
        // Pegar configurações e itens ativos do banco
        $settings = RouletteSetting::current();
        $roulette_items = RouletteItem::active()->get()->map(function($item) {
            return [
                'id' => $item->item_id,
                'name' => $item->name,
                'quantity' => $item->quantity,
                'probability' => $item->probability,
                'image' => $item->image
            ];
        })->toArray();
        
        // Obter histórico recente do usuário com paginação (5 por página)
        $history = RouletteLog::where('account_id', $account_id)
            ->orderBy('spin_date', 'desc')
            ->paginate(5);

        return view('roulette.index', [
            'cash_points' => $cash_points,
            'spin_cost' => $settings->spin_cost,
            'roulette_items' => $roulette_items,
            'history' => $history
        ]);
    }

    // Processar giro da roleta via AJAX
    public function spin(Request $request)
    {
        if (!session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa estar logado.'
            ], 401);
        }

        // Verificar se a roleta está ativa
        if (!RouletteSetting::isActive()) {
            return response()->json([
                'success' => false,
                'message' => 'A roleta está temporariamente desativada.'
            ]);
        }

        $userId = session('user_id');
        $userEmail = session('email');
        $settings = RouletteSetting::current();
        $spin_cost = $settings->spin_cost;

        // Buscar account_id da tabela login usando o email
        $loginAccount = DB::connection('ragnarok')->table('login')
            ->where('email', $userEmail)
            ->first();

        if (!$loginAccount) {
            return response()->json([
                'success' => false,
                'message' => 'Você precisa criar uma conta de jogo primeiro.'
            ]);
        }

        $account_id = $loginAccount->account_id;

        // Recarregar cash points antes de processar
        $cash_points = $this->getCashPoints($account_id);

        if ($cash_points < $spin_cost) {
            return response()->json([
                'success' => false,
                'message' => "Você não tem Cash Points suficientes! (Você tem: $cash_points, Necessário: {$spin_cost})"
            ]);
        }

        try {
            // Verificar se o jogador tem um personagem
            $char = DB::connection('ragnarok')->table('char')
                ->where('account_id', $account_id)
                ->first();

            if (!$char) {
                return response()->json([
                    'success' => false,
                    'message' => 'Você precisa criar um personagem antes de girar a roleta!'
                ]);
            }

            $char_id = $char->char_id;

            // Deduzir os cash points
            $updated = DB::connection('ragnarok')->table('acc_reg_num')
                ->where('account_id', $account_id)
                ->where('key', '#CASHPOINTS')
                ->update(['value' => DB::raw('value - ' . $spin_cost)]);

            // Se não houver linhas afetadas, criar o registro
            if ($updated == 0) {
                $new_value = $cash_points - $spin_cost;
                DB::connection('ragnarok')->table('acc_reg_num')->insert([
                    'account_id' => $account_id,
                    'key' => '#CASHPOINTS',
                    'index' => 0,
                    'value' => $new_value
                ]);
            }

            // Atualizar cash points
            $cash_points -= $spin_cost;

            // Pegar itens ativos e selecionar item com WEIGHTED RANDOM
            $active_items = RouletteItem::active()->get();
            $winning_item_db = $this->weightedRandomFromDb($active_items);
            
            // Encontrar o índice do item vencedor (para a animação)
            $winning_index = 0;
            foreach ($active_items as $index => $item) {
                if ($item->id === $winning_item_db->id) {
                    $winning_index = $index;
                    break;
                }
            }
            
            $won_item = [
                'id' => $winning_item_db->item_id,
                'name' => $winning_item_db->name,
                'quantity' => $winning_item_db->quantity,
                'probability' => $winning_item_db->probability
            ];

            // Se ganhou item (item_id > 0), adicionar ao storage
            if ($won_item['id'] > 0) {
                $this->addItemToStorage($account_id, $won_item['id'], $won_item['quantity']);

                // Registrar no log
                RouletteLog::create([
                    'account_id' => $account_id,
                    'char_id' => $char_id,
                    'item_id' => $won_item['id'],
                    'item_name' => $won_item['name'],
                    'spin_date' => now(),
                ]);
            }

            // Retornar resultado
            return response()->json([
                'success' => true,
                'winning_index' => $winning_index,
                'item' => $won_item,
                'cash_points' => $cash_points
            ]);

        } catch (\Exception $e) {
            Log::error('Roulette spin error', [
                'account_id' => $account_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o giro: ' . $e->getMessage()
            ], 500);
        }
    }

    // Página de histórico completo
    public function history()
    {
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $userId = session('user_id');
        $userEmail = session('email');
        
        // Buscar account_id da tabela login usando o email
        $loginAccount = DB::connection('ragnarok')->table('login')
            ->where('email', $userEmail)
            ->first();
        
        if (!$loginAccount) {
            return redirect('/account')->with('message', 'Você precisa criar uma conta de jogo primeiro.')
                ->with('message_type', 'error');
        }

        $account_id = $loginAccount->account_id;
        
        $history = RouletteLog::where('account_id', $account_id)
            ->orderBy('spin_date', 'desc')
            ->paginate(20);

        return view('roulette.history', compact('history'));
    }

    // FUNÇÃO EXATA DO PHP: Obter cash points
    private function getCashPoints($account_id)
    {
        try {
            $result = DB::connection('ragnarok')->table('acc_reg_num')
                ->where('account_id', $account_id)
                ->where('key', '#CASHPOINTS')
                ->value('value');

            return $result ? intval($result) : 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    // Função para selecionar item com weighted random usando banco de dados
    private function weightedRandomFromDb($items)
    {
        // Criar array de pesos baseado na probabilidade de cada item
        $weights = [];
        $items_array = [];
        
        foreach ($items as $item) {
            $items_array[] = $item;
            $weights[] = $item->probability;
        }

        // Calcular total de pesos
        $total_weight = array_sum($weights);
        
        // Gerar número aleatório
        $random = mt_rand(1, $total_weight);
        
        // Selecionar item baseado no peso
        $offset = 0;
        foreach ($weights as $index => $weight) {
            $offset += $weight;
            if ($random <= $offset) {
                return $items_array[$index];
            }
        }
        
        // Fallback para primeiro item
        return $items_array[0];
    }

    // Adicionar item ao storage
    private function addItemToStorage($account_id, $item_id, $quantity = 1)
    {
        try {
            // Verificar se o item já existe no storage
            $existing = DB::connection('ragnarok')->table('storage')
                ->where('account_id', $account_id)
                ->where('nameid', $item_id)
                ->first();

            if ($existing) {
                // Atualizar quantidade do item existente
                DB::connection('ragnarok')->table('storage')
                    ->where('id', $existing->id)
                    ->increment('amount', $quantity);
            } else {
                // Adicionar novo item ao storage
                DB::connection('ragnarok')->table('storage')->insert([
                    'account_id' => $account_id,
                    'nameid' => $item_id,
                    'amount' => $quantity,
                    'identify' => 1,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to add item to storage', [
                'account_id' => $account_id,
                'item_id' => $item_id,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
        }
    }
}
