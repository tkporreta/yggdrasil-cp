<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RouletteItem;
use App\Models\RouletteSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RouletteController extends Controller
{
    // Página principal de gerenciamento
    public function index(Request $request)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        // Se for POST, processar salvamento de configurações
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'spin_cost' => 'required|integer|min:1',
                'is_active' => 'nullable|boolean',
            ]);

            $settings = RouletteSetting::current();
            $settings->spin_cost = $validated['spin_cost'];
            $settings->is_active = $request->has('is_active');
            $settings->save();

            Log::info('Configurações da roleta atualizadas', [
                'admin_id' => $user->id,
                'spin_cost' => $settings->spin_cost,
                'is_active' => $settings->is_active
            ]);

            return redirect()->route('admin.roulette.index')
                ->with('message', 'Configurações da roleta atualizadas com sucesso!')
                ->with('message_type', 'success');
        }

        $items = RouletteItem::orderBy('probability', 'desc')->get();
        $settings = RouletteSetting::current();

        // Estatísticas
        $stats = [
            'total_items' => RouletteItem::count(),
            'active_items' => RouletteItem::where('is_active', true)->count(),
            'inactive_items' => RouletteItem::where('is_active', false)->count(),
            'total_probability' => RouletteItem::where('is_active', true)->sum('probability'),
        ];

        return view('admin.roulette.index', compact('items', 'settings', 'stats'));
    }

    // Formulário de criar item
    public function create(Request $request)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        return view('admin.roulette.create');
    }

    // Salvar novo item
    public function store(Request $request)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'probability' => 'required|integer|min:1|max:100',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $item = RouletteItem::create($validated);

        Log::info('Roulette item created by admin', [
            'admin_user_id' => session('user_id'),
            'item_id' => $item->id,
            'item_name' => $item->name
        ]);

        return redirect()->route('admin.roulette.index')
            ->with('success', 'Item "' . $item->name . '" adicionado com sucesso!');
    }

    // Formulário de editar item
    public function edit($id)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $item = RouletteItem::findOrFail($id);
        return view('admin.roulette.edit', compact('item'));
    }

    // Atualizar item
    public function update(Request $request, $id)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $item = RouletteItem::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'item_id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'probability' => 'required|integer|min:1|max:100',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $item->update($validated);

        Log::info('Roulette item updated by admin', [
            'admin_user_id' => session('user_id'),
            'item_id' => $item->id,
            'item_name' => $item->name
        ]);

        return redirect()->route('admin.roulette.index')
            ->with('success', 'Item "' . $item->name . '" atualizado com sucesso!');
    }

    // Deletar item
    public function destroy($id)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $item = RouletteItem::findOrFail($id);
        $itemName = $item->name;
        $item->delete();

        Log::info('Roulette item deleted by admin', [
            'admin_user_id' => session('user_id'),
            'item_id' => $id,
            'item_name' => $itemName
        ]);

        return redirect()->route('admin.roulette.index')
            ->with('success', 'Item "' . $itemName . '" removido com sucesso!');
    }

    // Ativar/Desativar item
    public function toggleStatus($id)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return response()->json(['success' => false, 'message' => 'Não autorizado'], 401);
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Acesso negado'], 403);
        }

        $item = RouletteItem::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        Log::info('Roulette item status toggled by admin', [
            'admin_user_id' => session('user_id'),
            'item_id' => $item->id,
            'item_name' => $item->name,
            'new_status' => $item->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $item->is_active,
            'message' => $item->is_active ? 'Item ativado!' : 'Item desativado!'
        ]);
    }

    // Atualizar configurações da roleta
    public function updateSettings(Request $request)
    {
        // Verificar se é admin
        if (!session('user_id')) {
            return redirect('/account')->with('message', 'Você precisa estar logado.')
                ->with('message_type', 'error');
        }

        $user = User::find(session('user_id'));
        if (!$user || $user->role !== 'admin') {
            return redirect('/account')->with('message', 'Acesso negado.')
                ->with('message_type', 'error');
        }

        $validated = $request->validate([
            'spin_cost' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $settings = RouletteSetting::current();
        $settings->update($validated);

        Log::info('Roulette settings updated by admin', [
            'admin_user_id' => session('user_id'),
            'spin_cost' => $settings->spin_cost,
            'is_active' => $settings->is_active
        ]);

        return redirect()->route('admin.roulette.index')
            ->with('success', 'Configurações da roleta atualizadas com sucesso!');
    }
}
