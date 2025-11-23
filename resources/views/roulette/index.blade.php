@extends('layouts.app')

@section('title', 'Roleta de Prêmios')

@section('content')
<style>
    .roulette-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-bottom: 24px;
    }

    .points-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #f39c12, #e67e22);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 1.25rem;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(243, 156, 18, 0.3);
    }

    .roulette-slots {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        background: #f8f9fa;
        border-radius: 8px;
        margin: 20px auto;
        height: 130px;
        max-width: 700px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .roulette-container {
        display: flex;
        gap: 8px;
        position: relative;
        will-change: transform;
        padding: 0;
        align-items: center;
    }

    .roulette-slot {
        width: 70px;
        min-width: 70px;
        max-width: 70px;
        height: 90px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 8px;
        flex-shrink: 0;
        box-sizing: border-box;
        opacity: 1;
        transition: opacity 0.2s ease;
    }

    .roulette-center-marker {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 74px;
        height: 94px;
        border: 3px solid #f39c12;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(243, 156, 18, 0.6), inset 0 0 10px rgba(243, 156, 18, 0.2);
        background: transparent;
        pointer-events: none;
        z-index: 10;
    }

    .roulette-slot img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .roulette-slot .item-name {
        font-size: 0.65rem;
        color: #495057;
        text-align: center;
        margin-top: 4px;
        line-height: 1.1;
    }

    /* Raridade - Cores */
    .rarity-0 { border-color: #adb5bd; }
    .rarity-1 { border-color: #28a745; }
    .rarity-2 { border-color: #007bff; }
    .rarity-3 { border-color: #6f42c1; }
    .rarity-4 { border-color: #dc3545; }
    .rarity-5 { border-color: #ffc107; }

    .spin-button {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        border: none;
        border-radius: 8px;
        padding: 14px 32px;
        color: white;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(238, 90, 36, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .spin-button:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(238, 90, 36, 0.4);
    }

    .spin-button:disabled {
        background: linear-gradient(135deg, #adb5bd, #6c757d);
        cursor: not-allowed;
        opacity: 0.6;
    }

    .spin-button.spinning svg {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .history-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .history-item img {
        width: 35px;
        height: 35px;
    }

    .history-item .info {
        flex: 1;
    }

    .history-item .item-name {
        font-weight: 600;
        color: #212529;
        font-size: 0.9rem;
    }

    .history-item .date {
        color: #6c757d;
        font-size: 0.75rem;
    }

    .probability-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .probability-row:last-child {
        border-bottom: none;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        border-left: 4px solid #28a745;
        animation: slideIn 0.3s ease;
    }

    .notification.error {
        border-left-color: #dc3545;
    }

    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<div class="flex-1 small:py-12" data-testid="account-page">
    <div class="flex-1 h-full max-w-5xl mx-auto bg-white flex flex-col">
        <div class="grid grid-cols-1 small:grid-cols-[240px_1fr] py-12">
            <!-- Sidebar (mesmo das outras páginas) -->
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
                                <li><a class="hover:underline hover:text-ui-fg-base font-semibold uppercase font-robotoCond text-brand-main" href="/account/roulette">Roleta</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" href="/account/orders">Transactions</a></li>
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
            <div class="flex-1">
                <div class="w-full">
                    <!-- Page Title -->
                    <div class="w-full text-center text-brand-main mb-6">
                        <div class="flex items-center justify-center mb-1">
                            <span class="text-4xl mr-3">🎰</span>
                            <h1 class="uppercase text-2xl md:text-4xl font-core">Roleta de Prêmios</h1>
                        </div>
                        <p class="text-base font-robotoCond leading-6 mt-1">Teste sua sorte e ganhe itens incríveis!</p>
                    </div>

                    <!-- Account Selector -->
                    <div class="roulette-card mb-4">
                        <div class="text-sm text-gray-700 mb-3 font-semibold">🎮 Selecione a Conta de Jogo</div>
                        <div class="flex items-center gap-3">
                            <select id="account-selector" class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-brand-main focus:border-brand-main font-robotoCond text-sm">
                                @foreach($game_accounts as $account)
                                    <option value="{{ $account->account_id }}" {{ $account->account_id == $selected_account_id ? 'selected' : '' }}>
                                        {{ $account->userid }} (ID: {{ $account->account_id }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="text-xs text-gray-500">
                                Conta Selecionada: <span id="selected-account-name" class="font-semibold text-brand-main">{{ $selected_account_name }}</span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">
                            ℹ️ Os Cash Points serão deduzidos desta conta e os prêmios serão enviados para o storage desta conta.
                        </div>
                    </div>

                    <!-- Cash Points Display -->
                    <div class="roulette-card text-center">
                        <div class="text-sm text-gray-600 mb-2">Cash Points da Conta Selecionada</div>
                        <div class="points-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                            </svg>
                            <span id="cash-points">{{ number_format($cash_points) }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">Custo por giro: {{ number_format($spin_cost) }} CP</div>
                    </div>

                    <!-- Roulette Slots -->
                    <div class="roulette-card">
                        <div class="roulette-slots" id="roulette-slots">
                            <!-- Marcador central fixo -->
                            <div class="roulette-center-marker"></div>
                            <!-- Container que vai deslizar -->
                            <div class="roulette-container" id="roulette-container">
                                <!-- Slots serão gerados via JavaScript -->
                            </div>
                        </div>

                        <!-- Spin Button -->
                        <div class="text-center mt-6">
                            <button class="spin-button" id="spin-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Girar Roleta
                            </button>
                        </div>
                    </div>

                    <!-- History & Probabilities Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Recent History -->
                        <div class="roulette-card">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📜 Últimas Rolagens</h3>
                            <div class="space-y-2">
                                @forelse ($history as $item)
                                    <div class="history-item">
                                        <img src="https://static.divine-pride.net/images/items/item/{{ $item->item_id }}.png" 
                                             alt="{{ $item->item_name }}"
                                             onerror="this.src='data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;35&quot; height=&quot;35&quot;><text x=&quot;17.5&quot; y=&quot;17.5&quot; text-anchor=&quot;middle&quot; dominant-baseline=&quot;middle&quot; font-size=&quot;20&quot;>❓</text></svg>'">
                                        <div class="info">
                                            <div class="item-name">{{ $item->item_name }}</div>
                                            <div class="date">{{ \Carbon\Carbon::parse($item->spin_date)->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-400 text-center py-4">Nenhuma rolagem ainda</p>
                                @endforelse
                            </div>
                            
                            @if($history->hasPages())
                            <div class="flex justify-center gap-2 mt-4">
                                <!-- Seta esquerda -->
                                <a href="#" class="history-pagination-btn px-3 py-1 rounded {{ $history->onFirstPage() ? 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none' : 'bg-brand-main text-white hover:bg-brand-green' }} transition-colors" data-page="{{ $history->currentPage() - 1 }}">‹</a>
                                
                                @php
                                    $currentPage = $history->currentPage();
                                    $lastPage = $history->lastPage();
                                    $maxPages = 8;
                                    
                                    // Calcular range de páginas a exibir
                                    if ($lastPage <= $maxPages) {
                                        $startPage = 1;
                                        $endPage = $lastPage;
                                    } else {
                                        $startPage = max(1, $currentPage - floor($maxPages / 2));
                                        $endPage = min($lastPage, $startPage + $maxPages - 1);
                                        
                                        if ($endPage - $startPage < $maxPages - 1) {
                                            $startPage = max(1, $endPage - $maxPages + 1);
                                        }
                                    }
                                @endphp
                                
                                @foreach(range($startPage, $endPage) as $page)
                                    @if($page == $currentPage)
                                        <span class="px-3 py-1 rounded bg-brand-main text-white font-bold">{{ $page }}</span>
                                    @else
                                        <a href="#" class="history-pagination-btn px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" data-page="{{ $page }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                                
                                <!-- Seta direita -->
                                <a href="#" class="history-pagination-btn px-3 py-1 rounded {{ $history->hasMorePages() ? 'bg-brand-main text-white hover:bg-brand-green' : 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none' }} transition-colors" data-page="{{ $history->currentPage() + 1 }}">›</a>
                            </div>
                            @endif
                        </div>

                        <!-- Probability Table -->
                        <div class="roulette-card">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Probabilidades</h3>
                            <div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #adb5bd;"></span>
                                        <span class="text-gray-700">Perda</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">70%</span>
                                </div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #28a745;"></span>
                                        <span class="text-gray-700">Comum</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">35%</span>
                                </div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #007bff;"></span>
                                        <span class="text-gray-700">Incomum</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">25%</span>
                                </div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #6f42c1;"></span>
                                        <span class="text-gray-700">Raro</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">20%</span>
                                </div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #dc3545;"></span>
                                        <span class="text-gray-700">Épico</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">15%</span>
                                </div>
                                <div class="probability-row">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full" style="background-color: #ffc107;"></span>
                                        <span class="text-gray-700">Lendário</span>
                                    </span>
                                    <span class="font-semibold text-gray-900">5%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- GSAP Library para animações fluidas -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>

<script>
    const rouletteItemsData = @json($roulette_items);
    const spinBtn = document.getElementById('spin-btn');
    const cashPointsElement = document.getElementById('cash-points');
    const rouletteContainer = document.getElementById('roulette-container');
    const accountSelector = document.getElementById('account-selector');
    const selectedAccountName = document.getElementById('selected-account-name');
    let isAnimating = false;
    let slots = [];

    // Inicializar slots ao carregar
    function initializeSlots() {
        rouletteContainer.innerHTML = '';
        slots = [];
        
        // Verificar se há itens suficientes
        if (rouletteItemsData.length === 0) {
            console.error('Nenhum item disponível na roleta');
            showNotification('Nenhum item disponível na roleta', 'error');
            return;
        }
        
        // Criar 9 slots visíveis (4 antes do centro + 1 centro + 4 depois)
        for (let i = 0; i < 9; i++) {
            // Usar índice circular para repetir itens se houver poucos
            const item = rouletteItemsData[i % rouletteItemsData.length];
            const slot = createSlot(item);
            rouletteContainer.appendChild(slot);
            slots.push(slot);
        }
        
        console.log('Slots inicializados:', slots.length);
    }

    function createSlot(item) {
        const slot = document.createElement('div');
        slot.className = `roulette-slot rarity-${item.rarity || 0}`;
        
        slot.innerHTML = `
            <img src="https://static.divine-pride.net/images/items/item/${item.id}.png" 
                 alt="${item.name}"
                 onerror="this.src='data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;40&quot; height=&quot;40&quot;><text x=&quot;20&quot; y=&quot;20&quot; text-anchor=&quot;middle&quot; dominant-baseline=&quot;middle&quot; font-size=&quot;25&quot;>❓</text></svg>'">
            <div class="item-name">${item.name || '?'}</div>
        `;
        
        slot.dataset.itemId = item.id;
        slot.dataset.itemName = item.name;
        slot.dataset.rarity = item.rarity || 0;
        
        return slot;
    }
    // Event listener para mudança de conta
    accountSelector.addEventListener('change', function() {
        const accountId = this.value;
        const accountName = this.options[this.selectedIndex].text.split(' (ID:')[0];
        
        // Enviar requisição para trocar conta
        fetch('{{ route('roulette.selectAccount') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                account_id: accountId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizar cash points
                cashPointsElement.textContent = data.cash_points.toLocaleString('pt-BR');
                selectedAccountName.textContent = data.account_name;
                
                // Atualizar histórico
                loadHistoryForAccount(accountId);
                
                showNotification(`Conta alterada para: ${data.account_name}`, 'success');
            } else {
                showNotification(data.message || 'Erro ao trocar de conta', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erro ao trocar de conta', 'error');
        });
    });

    // Função para carregar histórico de uma conta específica
    function loadHistoryForAccount(accountId) {
        const url = new URL(window.location.href);
        url.searchParams.set('account_id', accountId);
        url.searchParams.delete('page'); // Reset para página 1

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Criar elemento temporário para parsear HTML
            const temp = document.createElement('div');
            temp.innerHTML = html;
            
            // Encontrar todas as roulette-cards
            const allCards = temp.querySelectorAll('.roulette-card');
            
            // Encontrar a card de histórico (aquela que contém "Últimas Rolagens")
            let newHistoryCard = null;
            allCards.forEach(card => {
                const h3 = card.querySelector('h3');
                if (h3 && h3.textContent.includes('Últimas Rolagens')) {
                    newHistoryCard = card;
                }
            });
            
            // Encontrar a card de histórico atual
            const currentCards = document.querySelectorAll('.roulette-card h3');
            let currentHistoryCard = null;
            currentCards.forEach(h3 => {
                if (h3.textContent.includes('Últimas Rolagens')) {
                    currentHistoryCard = h3.closest('.roulette-card');
                }
            });
            
            // Substituir conteúdo
            if (newHistoryCard && currentHistoryCard) {
                currentHistoryCard.innerHTML = newHistoryCard.innerHTML;
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Erro ao carregar histórico:', error);
        });
    }

    spinBtn.addEventListener('click', function() {
        if (spinBtn.disabled || isAnimating) return;

        spinBtn.disabled = true;
        isAnimating = true;
        spinBtn.classList.add('spinning');

        // AJAX para girar
        fetch('{{ route('roulette.spin') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animar slots com GSAP
                animateSlotsGSAP(data.winning_index, data.item, data.cash_points);
            } else {
                showNotification(data.message || 'Erro ao girar a roleta', 'error');
                spinBtn.disabled = false;
                isAnimating = false;
                spinBtn.classList.remove('spinning');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erro ao processar requisição', 'error');
            spinBtn.disabled = false;
            isAnimating = false;
            spinBtn.classList.remove('spinning');
        });
    });

    function animateSlotsGSAP(winningIndex, winningItem, newPoints) {
        const totalItems = 60; // Total de itens que vão "passar"
        const visibleSlots = 9; // Manter sempre 9 slots visíveis
        
        // Garantir que temos itens suficientes
        if (rouletteItemsData.length === 0) {
            showNotification('Erro: Nenhum item disponível na roleta', 'error');
            isAnimating = false;
            spinBtn.disabled = false;
            spinBtn.classList.remove('spinning');
            return;
        }
        
        // Criar array com todos os itens que vão aparecer
        const itemSequence = [];
        for (let i = 0; i < totalItems; i++) {
            if (i === totalItems - 5) { 
                // Item vencedor aparece exatamente para parar no centro (slot 4 de 9)
                itemSequence.push(winningItem);
            } else {
                // Usar aleatoriedade para repetir itens se houver poucos
                const randomItem = rouletteItemsData[Math.floor(Math.random() * rouletteItemsData.length)];
                itemSequence.push(randomItem);
            }
        }
        
        let currentIndex = 0;
        let animationSpeed = 30; // ms por frame inicialmente (bem rápido)
        const minSpeed = 30;
        const maxSpeed = 150; // ms por frame no final (lento)
        
        function updateFrame() {
            // Manter sempre exatamente 9 slots visíveis
            if (slots.length >= visibleSlots) {
                const firstSlot = slots.shift();
                if (firstSlot && firstSlot.parentNode) {
                    firstSlot.remove();
                }
            }
            
            // Adicionar novo slot no final
            if (currentIndex < itemSequence.length) {
                const newSlot = createSlot(itemSequence[currentIndex]);
                rouletteContainer.appendChild(newSlot);
                slots.push(newSlot);
                
                // Animar entrada suave
                gsap.fromTo(newSlot, 
                    { opacity: 0, scale: 0.8 },
                    { opacity: 1, scale: 1, duration: 0.2 }
                );
            }
            
            currentIndex++;
            
            // Calcular velocidade (desacelerar progressivamente)
            const progress = currentIndex / totalItems;
            animationSpeed = minSpeed + (maxSpeed - minSpeed) * Math.pow(progress, 3);
            
            // Continuar animação
            if (currentIndex < totalItems) {
                setTimeout(updateFrame, animationSpeed);
            } else {
                // Animação terminou - o item vencedor deve estar no centro (posição 4)
                setTimeout(() => {
                    const centerIndex = Math.floor(visibleSlots / 2); // Posição 4 (centro de 9)
                    const winningSlot = slots[centerIndex];
                    
                    if (!winningSlot) {
                        console.error('Slot vencedor não encontrado');
                        isAnimating = false;
                        spinBtn.disabled = false;
                        spinBtn.classList.remove('spinning');
                        return;
                    }
                    
                    // Verificar se é o item correto, senão forçar
                    if (parseInt(winningSlot.dataset.itemId) !== winningItem.id) {
                        console.log('Corrigindo item vencedor no centro');
                        winningSlot.className = `roulette-slot rarity-${winningItem.rarity || 0}`;
                        winningSlot.querySelector('img').src = `https://static.divine-pride.net/images/items/item/${winningItem.id}.png`;
                        winningSlot.querySelector('.item-name').textContent = winningItem.name;
                        winningSlot.dataset.itemId = winningItem.id;
                        winningSlot.dataset.itemName = winningItem.name;
                    }
                    
                    showWinningItem(winningSlot, winningItem, newPoints);
                }, 300);
            }
        }
        
        // Iniciar animação
        updateFrame();
    }

    function updateSlot(slot, item, isCenter) {
        slot.className = `roulette-slot rarity-${item.rarity || 0}`;
        
        const img = slot.querySelector('img');
        const imgSrc = `https://static.divine-pride.net/images/items/item/${item.id}.png`;
        
        // Só atualizar se for diferente (performance)
        if (img.src !== imgSrc) {
            img.src = imgSrc;
            img.alt = item.name;
            img.onerror = function() {
                this.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"><text x="25" y="25" text-anchor="middle" dominant-baseline="middle" font-size="30">❓</text></svg>';
            };
        }
        
        slot.querySelector('.item-name').textContent = item.name || '?';
    }

    function showWinningItem(winningSlot, winningItem, newPoints) {
        // Animar slot vencedor com pulso
        gsap.timeline()
            .to(winningSlot, {
                scale: 1.2,
                duration: 0.3,
                ease: "back.out(1.7)"
            })
            .to(winningSlot, {
                scale: 1,
                duration: 0.2
            })
            .to(winningSlot, {
                scale: 1.15,
                duration: 0.15,
                yoyo: true,
                repeat: 3
            });
        
        // Atualizar pontos com animação
        const currentPoints = parseInt(cashPointsElement.textContent.replace(/\./g, '')) || 0;
        gsap.to({ value: currentPoints }, {
            value: newPoints,
            duration: 1,
            onUpdate: function() {
                cashPointsElement.textContent = Math.floor(this.targets()[0].value).toLocaleString('pt-BR');
            }
        });

        // Mostrar notificação
        if (winningItem.id > 0) {
            showNotification(`🎉 Você ganhou: ${winningItem.name}!`, 'success');
        } else {
            showNotification('😢 Que pena! Tente novamente.', 'error');
        }

        // Reabilitar botão e resetar slots após 2 segundos
        setTimeout(() => {
            isAnimating = false;
            spinBtn.disabled = false;
            spinBtn.classList.remove('spinning');
            // Resetar slots para estado inicial
            initializeSlots();
        }, 2500);
    }

    function animateSlots(winningIndex, winningItem, newPoints) {
        // Fallback para navegadores sem GSAP (mantido por segurança)
        animateSlotsGSAP(winningIndex, winningItem, newPoints);
    }

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 4000);
    }

    // Paginação AJAX do histórico
    function loadHistoryPage(page) {
        const historyContainer = document.querySelector('.roulette-card .space-y-2').parentElement;
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);

        fetch(url.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            // Criar um elemento temporário para parsear o HTML
            const temp = document.createElement('div');
            temp.innerHTML = html;
            
            // Extrair apenas a seção do histórico
            const newHistory = temp.querySelector('.roulette-card .space-y-2').parentElement;
            
            if (newHistory) {
                historyContainer.innerHTML = newHistory.innerHTML;
                
                // Reativar os event listeners nos novos botões
                attachPaginationListeners();
            }
        })
        .catch(error => {
            console.error('Erro ao carregar histórico:', error);
        });
    }

    function attachPaginationListeners() {
        document.querySelectorAll('.history-pagination-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.dataset.page;
                if (page) {
                    loadHistoryPage(page);
                }
            });
        });
    }

    // Ativar listeners e inicializar slots na primeira carga
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM carregado, inicializando slots...');
        console.log('rouletteContainer:', rouletteContainer);
        console.log('Itens disponíveis:', rouletteItemsData.length);
        
        // Garantir que GSAP está carregado
        if (typeof gsap === 'undefined') {
            console.error('GSAP não carregado!');
        }
        
        // Inicializar slots
        setTimeout(() => {
            initializeSlots();
            attachPaginationListeners();
        }, 100);
    });
</script>
@endsection
