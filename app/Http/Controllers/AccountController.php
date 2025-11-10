<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Models\YggPoint;
use App\Models\VotePoint;

class AccountController extends Controller
{
    public function show()
    {
        if (!session('user_id')) {
            return view('account');
        }
        
        $userId = session('user_id');
        $userPoints = YggPoint::getPoints($userId);
        
        return view('overview', [
            'userPoints' => $userPoints
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
            'password.required' => 'A senha é obrigatória.',
        ]);

        // Verificar se o usuário existe na tabela users
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login bem-sucedido
            session(['user_id' => $user->id, 'email' => $user->email, 'name' => $user->name, 'first_name' => $user->first_name]);
            return redirect('/account')->with('message', 'Login realizado com sucesso!')->with('message_type', 'success');
        }

        return back()->with('message', 'Email ou senha incorretos.')->with('message_type', 'error');
    }

    public function register(Request $request)
    {
        \Log::info('Tentativa de registro:', $request->all());
        
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|max:255|confirmed',
        ], [
            'first_name.required' => 'O primeiro nome é obrigatório.',
            'last_name.required' => 'O sobrenome é obrigatório.',
            'email.unique' => 'Este email já está cadastrado.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ]);

        \Log::info('Validação passou, prosseguindo com criação da conta');

        try {
            // Criar usuário na tabela users
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
            ]);

            return redirect('/account')->with('message', 'Conta criada com sucesso! Você pode fazer login agora.')->with('message_type', 'success');
        } catch (\Exception $e) {
            // Log do erro para debug
            \Log::error('Erro ao criar conta: ' . $e->getMessage());
            
            return back()->with('message', 'Erro ao criar conta: ' . $e->getMessage())->with('message_type', 'error');
        }
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Digite um email válido.',
        ]);

        // Verificar se o email existe na tabela users
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Aqui você implementaria o envio real do email de reset
            // Por enquanto, apenas simula
            return back()->with('message', 'Se o email existir em nossa base, você receberá instruções para redefinir sua senha.')->with('message_type', 'success');
        }

        return back()->with('message', 'Se o email existir em nossa base, você receberá instruções para redefinir sua senha.')->with('message_type', 'success');
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/account')->with('message', 'Logout realizado com sucesso.')->with('message_type', 'success');
    }

    public function profile()
    {
        if (!session('user_id')) {
            return redirect('/account');
        }
        return view('profile');
    }

    public function gameAccounts()
    {
        if (!session('user_id')) {
            return redirect('/account');
        }

        // Buscar contas de jogo do usuário logado
        $gameAccounts = DB::connection('ragnarok')
            ->table('login')
            ->where('email', session('email'))
            ->select('account_id', 'userid', 'sex', 'state', 'lastlogin', 'character_slots')
            ->get();

        return view('game-accounts', compact('gameAccounts'));
    }

    public function yggPoints()
    {
        if (!session('user_id')) {
            return redirect('/account');
        }
        return view('ygg-points');
    }

    public function orders()
    {
        if (!session('user_id')) {
            return redirect('/account');
        }
        
        $userId = session('user_id');
        
        // Buscar transferências do usuário
        $transfers = DB::table('point_transfers')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($transfer) {
                // Buscar informações da conta de destino
                $account = DB::connection('ragnarok')
                    ->table('login')
                    ->where('account_id', $transfer->account_id)
                    ->first();
                
                $transfer->account_name = $account ? $account->userid : 'Conta #' . $transfer->account_id;
                return $transfer;
            });
        
        return view('orders', ['transfers' => $transfers]);
    }

    public function createGameAccount(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/account');
        }

        $request->validate([
            'userid' => 'required|string|max:23|unique:login,userid|regex:/^[a-zA-Z0-9_]+$/',
            'user_pass' => 'required|string|min:6|max:32|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ], [
            'userid.required' => 'O User ID é obrigatório.',
            'userid.max' => 'O User ID deve ter no máximo 23 caracteres.',
            'userid.unique' => 'Este User ID já está em uso.',
            'userid.regex' => 'O User ID deve conter apenas letras, números e underscores.',
            'user_pass.required' => 'A senha é obrigatória.',
            'user_pass.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'user_pass.max' => 'A senha deve ter no máximo 32 caracteres.',
            'user_pass.regex' => 'A senha deve conter pelo menos uma letra e um número.',
        ]);

        try {
            $userId = session('user_id');
            
            // Criar conta na tabela login do rAthena
            DB::connection('ragnarok')->table('login')->insert([
                'userid' => $request->userid,
                'user_pass' => $request->user_pass, // Senha em texto plano conforme padrão rAthena
                'sex' => 'M', // Default para masculino
                'email' => session('email'), // Usar email do usuário logado
                'group_id' => 0, // Jogador normal
                'state' => 0, // Conta ativa
                'unban_time' => 0,
                'expiration_time' => 0,
                'logincount' => 0,
                'lastlogin' => null,
                'last_ip' => request()->ip(),
                'birthdate' => date('Y-m-d'),
                'character_slots' => 9, // Slots padrão
                'pincode' => '',
                'pincode_change' => 0,
                'vip_time' => 0,
                'old_group' => 0,
                'web_auth_token' => $userId, // Associar com o ID do usuário web
                'web_auth_token_enabled' => 0,
            ]);

            return back()->with('message', 'Conta de jogo criada com sucesso!')->with('message_type', 'success');
        } catch (\Exception $e) {
            \Log::error('Erro ao criar conta de jogo: ' . $e->getMessage());
            return back()->with('message', 'Erro ao criar conta de jogo: ' . $e->getMessage())->with('message_type', 'error');
        }
    }

    public function changeGameAccountPassword(Request $request)
    {
        if (!session('user_id')) {
            return redirect('/account');
        }

        $request->validate([
            'userid' => 'required|string|max:23',
            'new_password' => 'required|string|min:6|max:32|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ], [
            'userid.required' => 'O User ID é obrigatório.',
            'new_password.required' => 'A nova senha é obrigatória.',
            'new_password.min' => 'A senha deve ter pelo menos 6 caracteres.',
            'new_password.max' => 'A senha deve ter no máximo 32 caracteres.',
            'new_password.regex' => 'A senha deve conter pelo menos uma letra e um número.',
        ]);

        try {
            // Verificar se a conta pertence ao usuário logado
            $account = DB::connection('ragnarok')
                ->table('login')
                ->where('userid', $request->userid)
                ->where('email', session('email'))
                ->first();

            if (!$account) {
                return back()->with('message', 'Conta de jogo não encontrada ou não pertence a você.')->with('message_type', 'error');
            }

            // Atualizar senha
            DB::connection('ragnarok')
                ->table('login')
                ->where('userid', $request->userid)
                ->where('email', session('email'))
                ->update([
                    'user_pass' => $request->new_password,
                ]);

            return back()->with('message', 'Senha alterada com sucesso!')->with('message_type', 'success');
        } catch (\Exception $e) {
            \Log::error('Erro ao alterar senha: ' . $e->getMessage());
            return back()->with('message', 'Erro ao alterar senha: ' . $e->getMessage())->with('message_type', 'error');
        }
    }
}
