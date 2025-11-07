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
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        margin: 20px 0;
    }

    .roulette-slot {
        width: 70px;
        height: 90px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 8px;
        transition: all 0.2s ease;
    }

    .roulette-center-slot {
        transform: scale(1.1);
        border-color: #f39c12;
        box-shadow: 0 0 15px rgba(243, 156, 18, 0.4);
        background: #fff9f0;
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
                    <div class="mb-6 text-center">
                        <h1 class="text-2xl font-bold text-gray-900">🎰 Roleta de Prêmios</h1>
                        <p class="text-gray-600 mt-1">Teste sua sorte e ganhe itens incríveis!</p>
                    </div>

                    <!-- Cash Points Display -->
                    <div class="roulette-card text-center">
                        <div class="text-sm text-gray-600 mb-2">Seus Cash Points</div>
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
                            @for ($i = 0; $i < 7; $i++)
                                <div class="roulette-slot {{ $i === 3 ? 'roulette-center-slot' : '' }} rarity-0" data-index="{{ $i }}">
                                    <img src="https://static.divine-pride.net/images/items/item/501.png" 
                                         alt="Item"
                                         onerror="this.src='data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; width=&quot;40&quot; height=&quot;40&quot;><text x=&quot;20&quot; y=&quot;20&quot; text-anchor=&quot;middle&quot; dominant-baseline=&quot;middle&quot; font-size=&quot;25&quot;>❓</text></svg>'">
                                    <div class="item-name">?</div>
                                </div>
                            @endfor
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
                                @if($history->onFirstPage())
                                    <span class="px-3 py-1 rounded bg-gray-200 text-gray-400 cursor-not-allowed">‹</span>
                                @else
                                    <a href="#" class="history-pagination-btn px-3 py-1 rounded bg-brand-main text-white hover:bg-brand-green transition-colors" data-page="{{ $history->currentPage() - 1 }}">‹</a>
                                @endif
                                
                                @foreach(range(1, $history->lastPage()) as $page)
                                    @if($page == $history->currentPage())
                                        <span class="px-3 py-1 rounded bg-brand-main text-white font-bold">{{ $page }}</span>
                                    @else
                                        <a href="#" class="history-pagination-btn px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" data-page="{{ $page }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                                
                                @if($history->hasMorePages())
                                    <a href="#" class="history-pagination-btn px-3 py-1 rounded bg-brand-main text-white hover:bg-brand-green transition-colors" data-page="{{ $history->currentPage() + 1 }}">›</a>
                                @else
                                    <span class="px-3 py-1 rounded bg-gray-200 text-gray-400 cursor-not-allowed">›</span>
                                @endif
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

<script>
    const rouletteItemsData = @json($roulette_items);
    const spinBtn = document.getElementById('spin-btn');
    const cashPointsElement = document.getElementById('cash-points');
    const slots = document.querySelectorAll('.roulette-slot');

    // Inicializar slots com itens aleatórios ao carregar a página
    function initializeSlots() {
        slots.forEach((slot, index) => {
            const randomIndex = Math.floor(Math.random() * rouletteItemsData.length);
            const item = rouletteItemsData[randomIndex];
            
            slot.className = `roulette-slot ${index === 3 ? 'roulette-center-slot' : ''} rarity-${item.rarity}`;
            
            const img = slot.querySelector('img');
            img.src = `https://static.divine-pride.net/images/items/item/${item.id}.png`;
            img.alt = item.name;
            img.onerror = function() {
                this.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"><text x="25" y="25" text-anchor="middle" dominant-baseline="middle" font-size="30">❓</text></svg>';
            };
            
            slot.querySelector('.item-name').textContent = item.name;
        });
    }

    // Inicializar slots ao carregar
    initializeSlots();

    spinBtn.addEventListener('click', function() {
        if (spinBtn.disabled) return;

        spinBtn.disabled = true;
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
                // Animar slots
                animateSlots(data.winning_index, data.item, data.cash_points);
            } else {
                showNotification(data.message || 'Erro ao girar a roleta', 'error');
                spinBtn.disabled = false;
                spinBtn.classList.remove('spinning');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erro ao processar requisição', 'error');
            spinBtn.disabled = false;
            spinBtn.classList.remove('spinning');
        });
    });

    function animateSlots(winningIndex, winningItem, newPoints) {
        let currentFrame = 0;
        const totalFrames = 40;
        const frameInterval = 80;

        const animationInterval = setInterval(() => {
            currentFrame++;

            // Atualizar todos os slots com itens aleatórios
            slots.forEach((slot, index) => {
                const randomIndex = Math.floor(Math.random() * rouletteItemsData.length);
                const item = rouletteItemsData[randomIndex];
                
                slot.className = `roulette-slot ${index === 3 ? 'roulette-center-slot' : ''} rarity-${item.rarity}`;
                
                const img = slot.querySelector('img');
                img.src = `https://static.divine-pride.net/images/items/item/${item.id}.png`;
                img.alt = item.name;
                img.onerror = function() {
                    this.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"><text x="25" y="25" text-anchor="middle" dominant-baseline="middle" font-size="30">❓</text></svg>';
                };
                
                slot.querySelector('.item-name').textContent = item.name;
            });

            if (currentFrame >= totalFrames) {
                clearInterval(animationInterval);

                // Mostrar item vencedor no slot central
                const centerSlot = slots[3];
                centerSlot.className = `roulette-slot roulette-center-slot rarity-${winningItem.id > 0 ? '3' : '0'}`;
                
                const centerImg = centerSlot.querySelector('img');
                centerImg.src = `https://static.divine-pride.net/images/items/item/${winningItem.id}.png`;
                centerImg.alt = winningItem.name;
                centerImg.onerror = function() {
                    this.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"><text x="25" y="25" text-anchor="middle" dominant-baseline="middle" font-size="30">❓</text></svg>';
                };
                
                centerSlot.querySelector('.item-name').textContent = winningItem.name;

                // Atualizar pontos
                cashPointsElement.textContent = newPoints.toLocaleString('pt-BR');

                // Mostrar notificação
                if (winningItem.id > 0) {
                    showNotification(`🎉 Você ganhou: ${winningItem.name}!`, 'success');
                } else {
                    showNotification('😢 Que pena! Tente novamente.', 'error');
                }

                // Recarregar após 3 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            }
        }, frameInterval);
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

    // Ativar listeners na primeira carga
    document.addEventListener('DOMContentLoaded', function() {
        attachPaginationListeners();
    });
</script>
@endsection
