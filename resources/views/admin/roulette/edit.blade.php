@extends('layouts.app')

@section('title', 'Editar Item - Gerenciar Roleta')

@section('content')
<main class="max-w-[800px] mx-auto p-5">
    <div class="mb-8">
        <a href="{{ route('admin.roulette.index') }}" class="text-brand-main hover:underline font-robotoCond mb-4 inline-block">
            ← Voltar para Gerenciar Roleta
        </a>
        <h1 class="text-4xl font-bold font-robotoCond text-brand-main">Editar Item: {{ $item->name }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-8">
        <form action="{{ route('admin.roulette.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                    Nome do Item *
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name"
                    value="{{ old('name', $item->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond @error('name') border-red-500 @enderror"
                    placeholder="Ex: Poção de Cura, Ticket VIP, etc."
                    required
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600 font-robotoCond">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="item_id" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                        Item ID (Jogo) *
                    </label>
                    <input 
                        type="number" 
                        name="item_id" 
                        id="item_id"
                        value="{{ old('item_id', $item->item_id) }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond @error('item_id') border-red-500 @enderror"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500 font-robotoCond">ID do item no banco de dados do jogo</p>
                    @error('item_id')
                        <p class="mt-1 text-sm text-red-600 font-robotoCond">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                        Quantidade *
                    </label>
                    <input 
                        type="number" 
                        name="quantity" 
                        id="quantity"
                        value="{{ old('quantity', $item->quantity) }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond @error('quantity') border-red-500 @enderror"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500 font-robotoCond">Quantidade que o jogador receberá</p>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600 font-robotoCond">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="probability" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                    Probabilidade (Peso) *
                </label>
                <input 
                    type="number" 
                    name="probability" 
                    id="probability"
                    value="{{ old('probability', $item->probability) }}"
                    min="1"
                    max="100"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond @error('probability') border-red-500 @enderror"
                    required
                >
                <p class="mt-1 text-xs text-gray-500 font-robotoCond">
                    Peso da probabilidade (1-100). Quanto maior, mais chance de sair.
                    <br>
                    <span class="text-brand-main">Dica:</span> Itens raros = 1-5, Comuns = 20-40, Muito comuns = 50+
                </p>
                @error('probability')
                    <p class="mt-1 text-sm text-red-600 font-robotoCond">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                    URL da Imagem (Opcional)
                </label>
                <input 
                    type="text" 
                    name="image" 
                    id="image"
                    value="{{ old('image', $item->image) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond @error('image') border-red-500 @enderror"
                    placeholder="https://exemplo.com/imagem.png ou /img/item.png"
                >
                <p class="mt-1 text-xs text-gray-500 font-robotoCond">URL completa ou caminho relativo da imagem do item</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600 font-robotoCond">{{ $message }}</p>
                @enderror
                
                @if($item->image)
                <div class="mt-2">
                    <p class="text-xs text-gray-500 font-robotoCond mb-1">Preview:</p>
                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-16 h-16 object-contain border rounded">
                </div>
                @endif
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        name="is_active" 
                        id="is_active"
                        value="1"
                        {{ old('is_active', $item->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 text-brand-main focus:ring-brand-main border-gray-300 rounded"
                    >
                    <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700 font-robotoCond">
                        Item Ativo (aparecerá na roleta)
                    </label>
                </div>
            </div>

            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-brand-main text-white px-6 py-3 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors"
                >
                    ✓ Salvar Alterações
                </button>
                <a 
                    href="{{ route('admin.roulette.index') }}" 
                    class="px-6 py-3 border border-gray-300 rounded-md font-robotoCond font-bold text-gray-700 hover:bg-gray-50 transition-colors"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</main>
@endsection
