@extends('layouts.app')

@section('title', 'Gerenciar Roleta - Admin')

@section('content')
<main class="max-w-5xl mx-auto p-5">
    <div class="mb-8">
        <h1 class="text-4xl font-bold font-robotoCond text-brand-main text-center mb-4">🎰 Gerenciar Roleta</h1>
        <div class="flex justify-end">
            <a href="{{ route('admin.roulette.create') }}" class="bg-brand-main text-white px-6 py-3 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors">
                + Adicionar Item
            </a>
        </div>
    </div>

    @if(session('message'))
    <div class="mb-6 p-4 rounded-md {{ session('message_type') === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }} font-robotoCond">
        {{ session('message_type') === 'success' ? '✓' : '✗' }} {{ session('message') }}
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 font-robotoCond">
        ✓ {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 font-robotoCond">
        ✗ {{ session('error') }}
    </div>
    @endif

    <!-- Estatísticas -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-around items-center">
            <div class="text-center">
                <div class="text-sm font-robotoCond text-gray-600 uppercase mb-1">Total de Itens</div>
                <div class="text-2xl font-bold text-brand-main font-core">{{ $stats['total_items'] }}</div>
            </div>
            <div class="h-12 w-px bg-gray-300"></div>
            <div class="text-center">
                <div class="text-sm font-robotoCond text-gray-600 uppercase mb-1">Itens Ativos</div>
                <div class="text-2xl font-bold text-green-600 font-core">{{ $stats['active_items'] }}</div>
            </div>
            <div class="h-12 w-px bg-gray-300"></div>
            <div class="text-center">
                <div class="text-sm font-robotoCond text-gray-600 uppercase mb-1">Itens Inativos</div>
                <div class="text-2xl font-bold text-red-600 font-core">{{ $stats['inactive_items'] }}</div>
            </div>
            <div class="h-12 w-px bg-gray-300"></div>
            <div class="text-center">
                <div class="text-sm font-robotoCond text-gray-600 uppercase mb-1">Prob. Total</div>
                <div class="text-2xl font-bold text-blue-600 font-core">{{ $stats['total_probability'] }}</div>
            </div>
        </div>
    </div>

    <!-- Configurações da Roleta -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-bold font-robotoCond text-brand-main mb-4">⚙️ Configurações</h2>
        <form action="{{ route('admin.roulette.index') }}" method="POST" class="flex items-end gap-4">
            @csrf
            
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                    Custo por Giro (Cash Points)
                </label>
                <input 
                    type="number" 
                    name="spin_cost" 
                    value="{{ $settings->spin_cost }}" 
                    min="1"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond"
                    required
                >
            </div>

            <div class="flex items-center gap-2">
                <input 
                    type="checkbox" 
                    name="is_active" 
                    id="is_active" 
                    value="1"
                    {{ $settings->is_active ? 'checked' : '' }}
                    class="w-5 h-5 text-brand-main focus:ring-brand-main border-gray-300 rounded"
                >
                <label for="is_active" class="text-sm font-medium text-gray-700 font-robotoCond">
                    Roleta Ativa
                </label>
            </div>

            <button type="submit" class="bg-brand-main text-white px-6 py-2 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors">
                Salvar Configurações
            </button>
        </form>
    </div>

    <!-- Lista de Itens -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-xl font-bold font-robotoCond text-brand-main">📦 Itens da Roleta</h2>
        </div>

        @if($items->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Item ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Quantidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Probabilidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider font-robotoCond">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($items as $item)
                    <tr id="item-{{ $item->id }}" class="{{ !$item->is_active ? 'opacity-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($item->image)
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-10 h-10 mr-3 object-contain">
                                @else
                                <div class="w-10 h-10 mr-3 bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                    📦
                                </div>
                                @endif
                                <div class="text-sm font-medium text-gray-900 font-robotoCond">{{ $item->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600 font-mono">{{ $item->item_id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900 font-robotoCond">{{ $item->quantity }}x</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2" style="width: 100px;">
                                    <div class="bg-brand-main h-2.5 rounded-full" style="width: {{ $item->probability }}%"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-900 font-robotoCond">{{ $item->probability }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button 
                                onclick="toggleItemStatus({{ $item->id }})"
                                class="status-badge px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full font-robotoCond {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}"
                            >
                                <span id="status-text-{{ $item->id }}">{{ $item->is_active ? 'Ativo' : 'Inativo' }}</span>
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.roulette.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 mr-3 font-robotoCond">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('admin.roulette.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover este item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-robotoCond">
                                    🗑️ Remover
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="p-12 text-center">
            <div class="text-6xl mb-4">🎰</div>
            <p class="text-gray-500 font-robotoCond text-lg">Nenhum item cadastrado na roleta ainda.</p>
            <a href="{{ route('admin.roulette.create') }}" class="inline-block mt-4 bg-brand-main text-white px-6 py-2 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors">
                Adicionar Primeiro Item
            </a>
        </div>
        @endif
    </div>
</main>

<script>
function toggleItemStatus(itemId) {
    fetch(`/admin/roulette/${itemId}/toggle`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById(`item-${itemId}`);
            const statusText = document.getElementById(`status-text-${itemId}`);
            const statusBadge = statusText.parentElement;
            
            if (data.is_active) {
                row.classList.remove('opacity-50');
                statusBadge.classList.remove('bg-red-100', 'text-red-800');
                statusBadge.classList.add('bg-green-100', 'text-green-800');
                statusText.textContent = 'Ativo';
            } else {
                row.classList.add('opacity-50');
                statusBadge.classList.remove('bg-green-100', 'text-green-800');
                statusBadge.classList.add('bg-red-100', 'text-red-800');
                statusText.textContent = 'Inativo';
            }
            
            // Mostrar mensagem
            const alertDiv = document.createElement('div');
            alertDiv.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded shadow-lg z-50 font-robotoCond';
            alertDiv.textContent = '✓ ' + data.message;
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao alterar status do item.');
    });
}
</script>
@endsection
