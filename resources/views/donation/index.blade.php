@extends('layouts.app')

@section('title', 'Ygg Points - Myth of Yggdrasil')
@section('description', 'Manage your Ygg Points balance and transactions.')

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
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="overview-link" href="/account"><div class="flex items-center gap-x-2"><span>Overview</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="game-accounts-link" href="/account/game-accounts"><div class="flex items-center gap-x-2"><span>Game Accounts</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="ygg-points-link" href="/account/ygg-points"><div class="flex items-center gap-x-2"><span>Ygg Points</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="votes-link" href="/account/votes"><div class="flex items-center gap-x-2"><span>Votos</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="roulette-link" href="/account/roulette"><div class="flex items-center gap-x-2"><span>Roleta</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="orders-link" href="/account/orders"><div class="flex items-center gap-x-2"><span>Transactions</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="download-link" href="/download"><div class="flex items-center gap-x-2"><span>Download</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li><a class="flex items-center justify-between py-4 border-b border-gray-200 px-8" data-testid="profile-link" href="/account/profile"><div class="flex items-center gap-x-2"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.6663 18V16.3333C16.6663 15.4493 16.3152 14.6014 15.69 13.9763C15.0649 13.3512 14.2171 13 13.333 13H6.66634C5.78229 13 4.93444 13.3512 4.30932 13.9763C3.6842 14.6014 3.33301 15.4493 3.33301 16.3333V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10.0003 9.66667C11.8413 9.66667 13.3337 8.17428 13.3337 6.33333C13.3337 4.49238 11.8413 3 10.0003 3C8.15938 3 6.66699 4.49238 6.66699 6.33333C6.66699 8.17428 8.15938 9.66667 10.0003 9.66667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg><span>Profile</span></div><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90"><path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></a></li>
                            <li>
                                <form method="POST" action="/logout" class="w-full">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-between py-4 border-b border-gray-200 px-8 w-full" data-testid="logout-button">
                                        <div class="flex items-center gap-x-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.167 1.944h3.11c.983 0 1.779.796 1.779 1.778v7.556c0 .982-.796 1.778-1.778 1.778H8.167"></path>
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.5 10.611 8.611 7.5 5.5 4.389M8.611 7.5H1.944"></path>
                                            </svg>
                                            <span>Log out</span>
                                        </div>
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform -rotate-90">
                                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="hidden small:block text-lg font-robotoCond" data-testid="account-nav">
                    <div>
                        <div class="pb-4 flex flex-row items-start gap-x-2">
                            <h3 class="font-core text-2xl uppercase leading-5">
                                <div class="flex items-center gap-x-1">Global<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" class="text-brand-main"><g fill="currentColor" clip-path="url(#a)"><path d="M11.016 2.825c.181.03.368-.02.513-.132l.136-.106A6.4 6.4 0 0 0 7.5 1.057a6.44 6.44 0 0 0-6.075 4.31c.606 1.364 1.388 2.429 2.354 3.135l.212.15q.119.083.23.164l.021.016c.262.196.488.41.603.728.084.233.074.418.06.652-.018.35-.043.783.26 1.286.278.462.638.652.901.79.201.106.294.159.379.287.248.372.124.943.059 1.17l-.033.111c.336.055.677.09 1.028.09a6.44 6.44 0 0 0 6.006-4.119c-.43-.971-.974-1.517-1.658-1.647-.724-.137-1.267.244-1.705.55-.37.256-.61.415-.853.366-.14-.025-.205-.09-.426-.356-.206-.247-.49-.587-.97-.87-.784-.458-1.756-.575-2.898-.35-.113-.32-.197-.784.02-1.224.047-.095.305-.577.774-.707.372-.103.732.073 1.11.259.424.208 1.004.492 1.564.136.627-.4.559-1.15.504-1.753-.04-.436-.086-.93.11-1.174.24-.301.948-.385 1.939-.23z"></path><path d="M7.5 14.611c-3.92 0-7.111-3.19-7.111-7.111S3.579.389 7.5.389s7.111 3.19 7.111 7.111-3.19 7.111-7.111 7.111m0-12.889A5.784 5.784 0 0 0 1.722 7.5 5.784 5.784 0 0 0 7.5 13.278 5.784 5.784 0 0 0 13.278 7.5 5.784 5.784 0 0 0 7.5 1.722"></path></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h15v15H0z"></path></clipPath></defs></svg></div>Account
                            </h3>
                        </div>
                        <div class="text-base-regular">
                            <ul class="flex mb-0 justify-start items-start flex-col gap-y-4">
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="overview-link" href="/account">Overview</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="game-accounts-link" href="/account/game-accounts">Game Accounts</a></li>
                                <li><a class="hover:underline hover:text-ui-fg-base font-semibold uppercase font-robotoCond text-brand-main" data-testid="ygg-points-link" href="/account/ygg-points">Ygg Points</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="votes-link" href="/account/votes">Votos</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="roulette-link" href="/account/roulette">Roleta</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="orders-link" href="/account/orders">Transactions</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="download-link" href="/download">Download</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="profile-link" href="/account/profile">Profile</a></li>
                                <li>
                                    <form method="POST" action="/logout" class="w-full">
                                        @csrf
                                        <button type="submit" data-testid="logout-button">
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
                    <div class="w-full text-start text-brand-main mb-8">
                        <div class="flex items-center mb-2">
                            <img alt="Ygg-point" loading="lazy" width="80" height="80" class="mr-4" src="/img/ygg-point.png">
                            <h1 class="uppercase text-4xl md:text-6xl font-core">Ygg Points</h1>
                        </div>
                    </div>
                    
                    @if(request()->get('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        ✅ Pagamento processado! Seus pontos serão adicionados em breve.
                    </div>
                    @endif

                    <div class="w-full mb-10">
                        <div class="prose prose-lg max-w-none">
                            <p class="text-lg font-robotoCond leading-7 my-4">Use seus Ygg Points na Myth Store para personalizar seu personagem e adquirir itens de qualidade de vida que facilitam sua jornada.</p>
                            <p class="text-lg font-robotoCond leading-7 my-4">Conquiste <em>Ygg Points</em> participando de desafios sazonais e eventos da comunidade.</p>
                            <p class="text-lg font-robotoCond leading-7 my-4">Você também pode apoiar financeiramente o Myth Team para obter ainda mais Ygg Points, impulsionando novos conteúdos e inovações.</p>
                        </div>
                    </div>
                    <div class="text-brand-main w-full">
                        <h2 class="text-4xl mb-6 font-core text-brand-main uppercase">Adquira Ygg Points com Seu Apoio</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                            @foreach($packages as $package)
                            <div class="product-card min-h-full flex flex-col justify-between items-center bg-ui-bg-default rounded-lg shadow-md">
                                <div class="w-full flex flex-col my-auto items-center">
                                    <img alt="Ygg-point" loading="lazy" width="180" height="180" class="product-image mb-4" src="{{ $package['image'] }}">
                                </div>
                                <h3 class="text-2xl font-robotoCond uppercase font-bold text-brand-main">{{ number_format($package['points']) }} Ygg Points</h3>
                                <p class="text-sm font-robotoCond text-brand-green font-semibold -mt-2">Bonus +{{ number_format($package['points'] * 0.05) }}</p>
                                <div class="mt-4 w-full flex flex-col items-center">
                                    <div class="flex flex-col gap-y-2">
                                        <div></div>
                                        <div class="w-full flex gap-3 items-center text-brand-main">
                                            <div class="flex flex-col text font-robotoCond text-brand-main text-l">
                                                <span class="text-xl-semi"><span class="text-brand-main" data-testid="product-price">R$ {{ number_format($package['amount'] / 100, 2, ',', '.') }}</span></span>
                                            </div>
                                            <button 
                                                onclick="obterYggPoints({{ $package['points'] }}, {{ $package['amount'] }})"
                                                class="transition-fg relative inline-flex items-center justify-center overflow-hidden border outline-none disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored border-ui-border-loud after:button-inverted-gradient hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 w-fit py-3 px-6 text-brand-main bg-slate-100 rounded-md hover:text-white hover:bg-brand-green focus:ring-2 focus:ring-brand-main focus:outline-none disabled:bg-gray-300 disabled:cursor-not-allowed transition-all border-none">
                                                Obter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col small:flex-row items-end justify-start small:border-t border-gray-200 py-12 gap-2">
            <div>
                <h3 class="text-3xl font-core leading-tight uppercase">Got questions?</h3>
                <span class="text-lg font-robotoCond text-ui-fg-base">You can find frequently asked questions and answers on our community:</span>
            </div>
            <div>
                <a href="https://discord.gg/mythofyggdrasil" target="_blank" rel="noreferrer" class="text-lg font-robotoCond text-ui-fg-base hover:underline flex gap-2 items-center font-bold uppercase justify-center">join our Discord<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path fill="#5865F2" d="M9.996 9.58c-.739 0-1.348-.678-1.348-1.511 0-.834.597-1.512 1.348-1.512s1.36.685 1.348 1.512c-.011.826-.59 1.511-1.348 1.511m-4.984 0c-.739 0-1.348-.678-1.348-1.511 0-.834.597-1.512 1.348-1.512s1.36.685 1.349 1.512c-.012.826-.598 1.511-1.349 1.511m7.684-6.85a12.4 12.4 0 0 0-3.052-.946.05.05 0 0 0-.05.023q-.21.38-.38.78a11.4 11.4 0 0 0-3.428 0 8 8 0 0 0-.386-.78.05.05 0 0 0-.05-.023c-1.054.181-2.080.5-3.052.946a.04.04 0 0 0-.02.017C.334 5.652-.199 8.486.062 11.287a.05.05 0 0 0 .02.034 12.4 12.4 0 0 0 3.744 1.894.05.05 0 0 0 .053-.017q.434-.591.766-1.247a.05.05 0 0 0-.027-.065 8 8 0 0 1-1.17-.558.05.05 0 0 1-.025-.04.05.05 0 0 1 .02-.042c.083-.06.158-.12.233-.182a.05.05 0 0 1 .048-.007c2.454 1.12 5.112 1.12 7.537 0a.05.05 0 0 1 .05.006 5 5 0 0 0 .233.182.05.05 0 0 1 .02.042.05.05 0 0 1-.024.04 7.7 7.7 0 0 1-1.166.555.1.1 0 0 0-.017.01.05.05 0 0 0-.014.037q0 .01.005.019.337.651.765 1.246a.047.047 0 0 0 .053.018 12.4 12.4 0 0 0 3.75-1.893.05.05 0 0 0 .02-.034c.312-3.235-.524-6.046-2.217-8.54a.04.04 0 0 0-.023-.015"></path></svg></a>
            </div>
        </div>
    </div>
</div>

<script>
function obterYggPoints(points, amount) {
    const button = event.target;
    button.disabled = true;
    button.textContent = 'Processando...';

    fetch('/donation/create-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            points: points,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Abrir URL do AbacatePay em nova aba
            window.open(data.payment_url, '_blank');
            
            // Reabilitar botão
            button.disabled = false;
            button.textContent = 'Obter';
            
            // Mostrar mensagem
            alert('Página de pagamento aberta! Complete o pagamento para receber seus Ygg Points.');
        } else {
            alert('Erro: ' + data.message);
            button.disabled = false;
            button.textContent = 'Obter';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao processar. Tente novamente.');
        button.disabled = false;
        button.textContent = 'Obter';
    });
}
</script>
@endsection
