@extends('layouts.app')

@section('title', 'Transferir Pontos - Myth of Yggdrasil')
@section('description', 'Transfira seus pontos para suas contas de jogo')

@section('content')
<div class="flex-1 small:py-12" data-testid="account-page">
    <div class="flex-1 h-full max-w-5xl mx-auto bg-white flex flex-col">
        <div class="grid grid-cols-1 small:grid-cols-[240px_1fr] py-12">
            <!-- Sidebar -->
            <div>
                <div class="small:hidden" data-testid="mobile-account-nav">
                    <div class="text-xl-semi mb-4 px-8">Hello {{ session('first_name') ?? 'User' }}</div>
                    <div class="text-base-regular">
                        <ul>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account"><div class="flex items-center gap-x-2"><span>Overview</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/game-accounts"><div class="flex items-center gap-x-2"><span>Game Accounts</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/ygg-points"><div class="flex items-center gap-x-2"><span>Ygg Points</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/votes"><div class="flex items-center gap-x-2"><span>Votos</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/roulette"><div class="flex items-center gap-x-2"><span>Roleta</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/orders"><div class="flex items-center gap-x-2"><span>Transactions</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/download"><div class="flex items-center gap-x-2"><span>Download</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" href="/account/profile"><div class="flex items-center gap-x-2"><span>Profile</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li>
                                <form method="POST" action="/logout" class="w-full">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-between py-4 border-b border-gray-200 px-8 w-full">
                                        <div class="flex items-center gap-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.167 1.944h3.11c.983 0 1.779.796 1.779 1.778v7.556c0 .982-.796 1.778-1.778 1.778H8.167"></path>
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.5 10.611 8.611 7.5 5.5 4.389M8.611 7.5H1.944"></path>
                                            </svg>
                                            <span>Log out</span>
                                        </div>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="hidden small:block text-lg font-robotoCond">
                    <div>
                        <div class="pb-4 flex flex-row items-start gap-x-2">
                            <h3 class="font-core text-2xl uppercase leading-5">
                                <div class="flex items-center gap-x-1">Global<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" class="text-brand-main"><g fill="currentColor" clip-path="url(#a)"><path d="M11.016 2.825c.181.03.368-.02.513-.132l.136-.106A6.4 6.4 0 0 0 7.5 1.057a6.44 6.44 0 0 0-6.075 4.31c.606 1.364 1.388 2.429 2.354 3.135l.212.15q.119.083.23.164l.021.016c.262.196.488.41.603.728.084.233.074.418.06.652-.018.35-.043.783.26 1.286.278.462.638.652.901.79.201.106.294.159.379.287.248.372.124.943.059 1.17l-.033.111c.336.055.677.09 1.028.09a6.44 6.44 0 0 0 6.006-4.119c-.43-.971-.974-1.517-1.658-1.647-.724-.137-1.267.244-1.705.55-.37.256-.61.415-.853.366-.14-.025-.205-.09-.426-.356-.206-.247-.49-.587-.97-.87-.784-.458-1.756-.575-2.898-.35-.113-.32-.197-.784.02-1.224.047-.095.305-.577.774-.707.372-.103.732.073 1.11.259.424.208 1.004.492 1.564.136.627-.4.559-1.15.504-1.753-.04-.436-.086-.93.11-1.174.24-.301.948-.385 1.939-.23z"></path><path d="M7.5 14.611c-3.92 0-7.111-3.19-7.111-7.111S3.579.389 7.5.389s7.111 3.19 7.111 7.111-3.19 7.111-7.111 7.111m0-12.889A5.784 5.784 0 0 0 1.722 7.5 5.784 5.784 0 0 0 7.5 13.278 5.784 5.784 0 0 0 13.278 7.5 5.784 5.784 0 0 0 7.5 1.722"></path></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h15v15H0z"></path></clipPath></defs></svg></div>Account
                            </h3>
                        </div>
                        <div class="text-base-regular">
                            <ul class="flex mb-0 justify-start items-start flex-col gap-y-4">
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account">Overview</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/game-accounts">Game Accounts</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/ygg-points">Ygg Points</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/votes">Votos</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/roulette">Roleta</a></li>
                                <li><a class="hover:underline hover:text-ui-fg-base font-semibold uppercase font-robotoCond text-brand-main" href="/account/orders">Transactions</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/download">Download</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/profile">Profile</a></li>
                                <li>
                                    <form method="POST" action="/logout" class="w-full">
                                        @csrf
                                        <button type="submit">
                                            <span class="flex gap-x-1 items-center text-grey-700 text-md uppercase font-robotoCond">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.167 1.944h3.11c.983 0 1.779.796 1.779 1.778v7.556c0 .982-.796 1.778-1.778 1.778H8.167"></path>
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.5 10.611 8.611 7.5 5.5 4.389M8.611 7.5H1.944"></path>
                                                </svg>
                                                Log out
                                            </span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 px-8">
                <div class="w-full">
                    <!-- Header -->
                    <header class="mb-6">
                        <h1 class="text-2xl-semi">Transferir Pontos</h1>
                        <p class="text-base-regular">Transfira seus pontos para suas contas de jogo</p>
                    </header>

                    <!-- Mensagens -->
                    @if(session('success'))
                        <div class="mb-4 p-4 rounded-md bg-green-100 border border-green-400">
                            <p class="text-green-700 font-robotoCond text-sm">✓ {{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 rounded-md bg-red-100 border border-red-400">
                            <p class="text-red-700 font-robotoCond text-sm">✗ {{ session('error') }}</p>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-md bg-red-100 border border-red-400">
                            <ul class="list-disc list-inside text-red-700 font-robotoCond text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Saldo Atual -->
                    <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gradient-to-r from-yellow-50 to-yellow-100 rounded-lg border border-yellow-200">
                            <div class="flex justify-between items-center">
                                <span class="font-robotoCond text-gray-700 text-sm">Ygg Points</span>
                                <span class="font-bold text-xl text-yellow-700 font-robotoCond">{{ number_format($yggPoints) }}</span>
                            </div>
                            <p class="text-xs text-gray-600 font-robotoCond mt-1">1 Ygg Point = 100 Cash Points</p>
                        </div>

                        <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg border border-blue-200">
                            <div class="flex justify-between items-center">
                                <span class="font-robotoCond text-gray-700 text-sm">Vote Points</span>
                                <span class="font-bold text-xl text-blue-700 font-robotoCond">{{ number_format($votePoints) }}</span>
                            </div>
                            <p class="text-xs text-gray-600 font-robotoCond mt-1">1 Vote Point = 1 Cash Point</p>
                        </div>
                    </div>

                    @if($accounts->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-gray-600 font-robotoCond mb-4">Você ainda não tem contas de jogo cadastradas.</p>
                            <a href="/account/game-accounts" class="text-brand-main hover:underline font-robotoCond font-semibold">
                                Criar uma conta agora →
                            </a>
                        </div>
                    @else
                        <!-- Formulário -->
                        <form action="{{ route('transfer.store') }}" method="POST" id="transferForm" class="bg-white border border-gray-200 rounded-lg p-6">
                            @csrf

                            <!-- Seleção de Conta -->
                            <div class="mb-4">
                                <label for="account_id" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                    Conta de Destino *
                                </label>
                                <select 
                                    name="account_id" 
                                    id="account_id"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond text-sm"
                                >
                                    <option value="">Selecione uma conta...</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->account_id }}" {{ old('account_id') == $account->account_id ? 'selected' : '' }}>
                                            {{ $account->userid }} (ID: {{ $account->account_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Grid com os inputs -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Ygg Points -->
                                <div>
                                    <label for="ygg_points" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                        Ygg Points
                                    </label>
                                    <input 
                                        type="number" 
                                        name="ygg_points" 
                                        id="ygg_points"
                                        value="{{ old('ygg_points', 0) }}"
                                        min="0"
                                        max="{{ $yggPoints }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond text-sm"
                                        placeholder="0"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 font-robotoCond">
                                        Max: {{ number_format($yggPoints) }} | Você receberá: <span id="yggCashPreview" class="font-bold text-brand-main">0</span> Cash
                                    </p>
                                </div>

                                <!-- Vote Points -->
                                <div>
                                    <label for="vote_points" class="block text-sm font-medium text-gray-700 font-robotoCond mb-2">
                                        Vote Points
                                    </label>
                                    <input 
                                        type="number" 
                                        name="vote_points" 
                                        id="vote_points"
                                        value="{{ old('vote_points', 0) }}"
                                        min="0"
                                        max="{{ $votePoints }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond text-sm"
                                        placeholder="0"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 font-robotoCond">
                                        Max: {{ number_format($votePoints) }} | Você receberá: <span id="voteCashPreview" class="font-bold text-brand-main">0</span> Cash
                                    </p>
                                </div>
                            </div>

                            <!-- Total Preview -->
                            <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-lg border border-green-200">
                                <div class="flex justify-between items-center">
                                    <span class="font-robotoCond text-gray-700 text-sm">Total Cash Points</span>
                                    <span id="totalCashPreview" class="font-bold text-2xl text-green-700 font-robotoCond">0</span>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="flex gap-4">
                                <button 
                                    type="submit"
                                    class="flex-1 bg-brand-main text-white px-6 py-3 rounded-md font-robotoCond font-bold hover:bg-brand-green transition-colors text-center"
                                >
                                    Confirmar Transferência
                                </button>
                                <a 
                                    href="/account/orders"
                                    class="flex-1 px-6 py-3 border border-gray-300 rounded-md font-robotoCond font-bold text-gray-700 hover:bg-gray-50 transition-colors text-center"
                                >
                                    Cancelar
                                </a>
                            </div>
                        </form>

                        <!-- Informações -->
                        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-bold font-robotoCond text-blue-900 text-sm mb-2">ℹ️ Informações</h3>
                            <ul class="text-xs text-blue-800 font-robotoCond space-y-1">
                                <li>• <strong>Ygg Points:</strong> Ganhos por doações - conversão 1:100</li>
                                <li>• <strong>Vote Points:</strong> Ganhos votando - conversão 1:1</li>
                                <li>• Cash Points são adicionados diretamente na conta de jogo</li>
                                <li>• A transferência é irreversível</li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

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
});
</script>
@endsection
