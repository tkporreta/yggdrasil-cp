@extends('layouts.app')

@section('title', 'Transfer Points')

@section('content')
<main class="max-w-5xl mx-auto p-5">
    <!-- Header com botão voltar -->
    <div class="mb-8">
        <a href="{{ url('/account/orders') }}" class="text-brand-main hover:underline font-robotoCond mb-4 inline-block">
            ← Voltar para Transactions
        </a>
        <h1 class="text-4xl font-bold font-robotoCond text-brand-main text-center">Nova Transferência</h1>
        <p class="text-center text-gray-600 font-robotoCond mt-2">Transfira seus pontos para suas contas do jogo</p>
    </div>

    <!-- Mensagens de sucesso/erro -->
    @if(session('success'))
        <div class="mb-6 p-4 rounded-md bg-green-100 border border-green-400">
            <p class="text-green-700 font-robotoCond">✓ {{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-md bg-red-100 border border-red-400">
            <p class="text-red-700 font-robotoCond">✗ {{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-md bg-red-100 border border-red-400">
            <ul class="list-disc list-inside text-red-700 font-robotoCond">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Saldo Atual -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold font-robotoCond text-gray-800 mb-4">💰 Seu Saldo</h2>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200">
                        <div class="flex justify-between items-center">
                            <span class="font-robotoCond text-gray-700">Ygg Points</span>
                            <span class="font-bold text-xl text-yellow-700 font-robotoCond">{{ number_format($yggPoints) }}</span>
                        </div>
                        <p class="text-xs text-gray-600 font-robotoCond mt-1">1 Ygg Point = 100 Cash Points</p>
                    </div>

                    <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                        <div class="flex justify-between items-center">
                            <span class="font-robotoCond text-gray-700">Vote Points</span>
                            <span class="font-bold text-xl text-blue-700 font-robotoCond">{{ number_format($votePoints) }}</span>
                        </div>
                        <p class="text-xs text-gray-600 font-robotoCond mt-1">1 Vote Point = 1 Cash Point</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário de Transferência -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold font-robotoCond text-gray-800 mb-6">🎮 Selecione a Conta e Valores</h2>

                @if($accounts->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-600 font-robotoCond mb-4">Você ainda não tem contas de jogo cadastradas.</p>
                        <a href="/account/game-accounts" class="text-brand-main hover:underline font-robotoCond">
                            Criar uma conta agora →
                        </a>
                    </div>
                @else
                    <form action="{{ route('transfer.store') }}" method="POST" id="transferForm">
                        @csrf

                        <!-- Seleção de Conta -->
                        <div class="mb-6">
                            <label for="account_id" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                Conta de Destino *
                            </label>
                            <select 
                                name="account_id" 
                                id="account_id"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond"
                            >
                                <option value="">Selecione uma conta...</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->account_id }}" {{ old('account_id') == $account->account_id ? 'selected' : '' }}>
                                        {{ $account->userid }} (ID: {{ $account->account_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ygg Points -->
                        <div class="mb-6">
                            <label for="ygg_points" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                Ygg Points para Transferir
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="ygg_points" 
                                    id="ygg_points"
                                    value="{{ old('ygg_points', 0) }}"
                                    min="0"
                                    max="{{ $yggPoints }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond"
                                    placeholder="0"
                                >
                                <div class="absolute right-3 top-3 text-gray-500 font-robotoCond text-sm">
                                    Max: {{ number_format($yggPoints) }}
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 font-robotoCond">
                                Você receberá: <span id="yggCashPreview" class="font-bold text-brand-main">0</span> Cash Points
                            </p>
                        </div>

                        <!-- Vote Points -->
                        <div class="mb-6">
                            <label for="vote_points" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                Vote Points para Transferir
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    name="vote_points" 
                                    id="vote_points"
                                    value="{{ old('vote_points', 0) }}"
                                    min="0"
                                    max="{{ $votePoints }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond"
                                    placeholder="0"
                                >
                                <div class="absolute right-3 top-3 text-gray-500 font-robotoCond text-sm">
                                    Max: {{ number_format($votePoints) }}
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 font-robotoCond">
                                Você receberá: <span id="voteCashPreview" class="font-bold text-brand-main">0</span> Cash Points
                            </p>
                        </div>

                        <!-- Total Preview -->
                        <div class="p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="font-robotoCond text-gray-700 font-medium">Total de Cash Points:</span>
                                <span class="font-bold text-2xl text-green-700 font-robotoCond" id="totalCashPreview">0</span>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="flex gap-4">
                            <button 
                                type="submit" 
                                class="flex-1 bg-brand-main text-white px-6 py-3 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors"
                            >
                                ✓ Confirmar Transferência
                            </button>
                            <a 
                                href="{{ url('/account/orders') }}" 
                                class="px-6 py-3 border border-gray-300 rounded-md font-robotoCond font-bold text-gray-700 hover:bg-gray-50 transition-colors text-center"
                            >
                                Cancelar
                            </a>
                        </div>
                    </form>
                @endif
            </div>

            <!-- Informações -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h3 class="font-bold font-robotoCond text-blue-900 mb-2">ℹ️ Como Funciona</h3>
                <ul class="text-sm text-blue-800 font-robotoCond space-y-1">
                    <li>• <strong>Ygg Points:</strong> Ganhos por doações - 1 Ygg Point = 100 Cash Points</li>
                    <li>• <strong>Vote Points:</strong> Ganhos votando no servidor - 1 Vote Point = 1 Cash Point</li>
                    <li>• Os Cash Points serão adicionados diretamente na conta de jogo selecionada</li>
                    <li>• A transferência é irreversível, verifique os valores antes de confirmar</li>
                    <li>• Você pode comprar Ygg Points em <a href="/account/ygg-points" class="underline font-bold">Doações</a> e ganhar Vote Points em <a href="/account/votes" class="underline font-bold">Votos</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const yggInput = document.getElementById('ygg_points');
    const voteInput = document.getElementById('vote_points');
    const yggPreview = document.getElementById('yggCashPreview');
    const votePreview = document.getElementById('voteCashPreview');
    const totalPreview = document.getElementById('totalCashPreview');

    function updatePreviews() {
        const yggPoints = parseInt(yggInput.value) || 0;
        const votePoints = parseInt(voteInput.value) || 0;
        
        const yggCash = yggPoints * 100;
        const voteCash = votePoints * 1;
        const total = yggCash + voteCash;

        yggPreview.textContent = yggCash.toLocaleString();
        votePreview.textContent = voteCash.toLocaleString();
        totalPreview.textContent = total.toLocaleString();
    }

    yggInput.addEventListener('input', updatePreviews);
    voteInput.addEventListener('input', updatePreviews);

    // Atualizar previews no carregamento
    updatePreviews();
});
</script>
@endsection
