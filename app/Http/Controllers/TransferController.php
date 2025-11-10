<?php

namespace App\Http\Controllers;

use App\Models\YggPoint;
use App\Models\VotePoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{
    /**
     * Exibe o formulário de transferência
     */
    public function index()
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/account')->with('message', 'Você precisa estar logado.');
        }

        // Buscar contas de jogo do usuário no banco Ragnarok
        $accounts = DB::connection('ragnarok')
            ->table('login')
            ->where('web_auth_token', $userId)
            ->select('account_id', 'userid')
            ->get();

        // Buscar saldo de Ygg Points (doações)
        $yggPoints = YggPoint::getPoints($userId);

        // Buscar saldo de Vote Points (votos)
        $votePoints = VotePoint::getPoints($userId);

        return view('transfer.index', compact('accounts', 'yggPoints', 'votePoints'));
    }

    /**
     * Processa a transferência de pontos
     */
    public function transfer(Request $request)
    {
        $userId = session('user_id');
        
        if (!$userId) {
            return redirect('/login')->with('error', 'You must be logged in.');
        }

        // Validação
        $request->validate([
            'account_id' => 'required|integer',
            'ygg_points' => 'nullable|integer|min:0',
            'vote_points' => 'nullable|integer|min:0',
        ]);

        $accountId = $request->account_id;
        $yggPointsToTransfer = (int)$request->ygg_points ?? 0;
        $votePointsToTransfer = (int)$request->vote_points ?? 0;

        // Verificar se há algo para transferir
        if ($yggPointsToTransfer === 0 && $votePointsToTransfer === 0) {
            return back()->with('error', 'Você precisa especificar pelo menos um tipo de pontos para transferir.');
        }

        // Verificar se a conta pertence ao usuário
        $accountExists = DB::connection('ragnarok')
            ->table('login')
            ->where('account_id', $accountId)
            ->where('web_auth_token', $userId)
            ->exists();

        if (!$accountExists) {
            return back()->with('error', 'Conta inválida.');
        }

        try {
            DB::beginTransaction();

            $totalCashPoints = 0;

            // Validar e deduzir Ygg Points
            if ($yggPointsToTransfer > 0) {
                $currentYggPoints = YggPoint::getPoints($userId);

                if ($currentYggPoints < $yggPointsToTransfer) {
                    DB::rollBack();
                    return back()->with('error', "Saldo insuficiente de Ygg Points. Você tem {$currentYggPoints} pontos.");
                }

                // Deduzir pontos usando o modelo
                YggPoint::deductPoints($userId, $yggPointsToTransfer);

                // Calcular Cash Points (1 Ygg Point = 100 Cash Points)
                $totalCashPoints += $yggPointsToTransfer * 100;
            }

            // Validar e deduzir Vote Points
            if ($votePointsToTransfer > 0) {
                $currentVotePoints = VotePoint::getPoints($userId);

                if ($currentVotePoints < $votePointsToTransfer) {
                    DB::rollBack();
                    return back()->with('error', "Saldo insuficiente de Vote Points. Você tem {$currentVotePoints} pontos.");
                }

                // Deduzir pontos usando o modelo
                VotePoint::deductPoints($userId, $votePointsToTransfer);

                // Calcular Cash Points (1 Vote Point = 1 Cash Point)
                $totalCashPoints += $votePointsToTransfer;
            }

            // Adicionar Cash Points à conta do jogo
            if ($totalCashPoints > 0) {
                $this->addCashPoints($accountId, $totalCashPoints);
            }

            // Registrar transação
            DB::connection('mysql')->table('point_transfers')->insert([
                'user_id' => $userId,
                'account_id' => $accountId,
                'ygg_points' => $yggPointsToTransfer,
                'vote_points' => $votePointsToTransfer,
                'cash_points' => $totalCashPoints,
                'created_at' => now(),
            ]);

            DB::commit();

            $message = "Transferência realizada com sucesso! ";
            if ($yggPointsToTransfer > 0) {
                $message .= "{$yggPointsToTransfer} Ygg Points convertidos em " . ($yggPointsToTransfer * 100) . " Cash Points. ";
            }
            if ($votePointsToTransfer > 0) {
                $message .= "{$votePointsToTransfer} Vote Points convertidos em {$votePointsToTransfer} Cash Points.";
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro na transferência de pontos', [
                'user_id' => $userId,
                'account_id' => $accountId,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Erro ao processar transferência. Tente novamente.');
        }
    }

    /**
     * Adiciona Cash Points à conta no banco Ragnarok
     */
    private function addCashPoints($accountId, $amount)
    {
        // Verificar se já existe registro de #CASHPOINTS
        $existing = DB::connection('ragnarok')
            ->table('acc_reg_num')
            ->where('account_id', $accountId)
            ->where('key', '#CASHPOINTS')
            ->first();

        if ($existing) {
            // Atualizar valor existente
            DB::connection('ragnarok')
                ->table('acc_reg_num')
                ->where('account_id', $accountId)
                ->where('key', '#CASHPOINTS')
                ->increment('value', $amount);
        } else {
            // Criar novo registro
            DB::connection('ragnarok')
                ->table('acc_reg_num')
                ->insert([
                    'account_id' => $accountId,
                    'key' => '#CASHPOINTS',
                    'index' => 0,
                    'value' => $amount,
                ]);
        }
    }
}
