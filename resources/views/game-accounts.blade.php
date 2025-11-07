@extends('layouts.app')

@section('title', 'Game Accounts')
@section('description', 'All your game accounts in one place')

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
                                <li><a class="hover:underline hover:text-ui-fg-base font-semibold uppercase font-robotoCond text-brand-main" data-testid="game-accounts-link" href="/account/game-accounts">Game Accounts</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="ygg-points-link" href="/account/ygg-points">Ygg Points</a></li>
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
                @if(session('message'))
                    <div class="mb-4 p-4 rounded-md {{ session('message_type') === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="flex flex-col">
                    <h1 class="font-medium h1-core font-core text-6xl uppercase">Game Accounts</h1>
                    <p>Aqui você pode criar e gerenciar suas contas de jogo.<!-- --> <br></p>
                    <div class="my-10 max-w-sm bg-white border border-gray-200 rounded-md p-5 shadow-sm text-sm leading-snug">
                        <div class="max-w-sm flex flex-col items-center" data-testid="create-account-form">
                            <h1 class="text-large-semi font-robotoCond uppercase mb-3 items-start w-full">criar nova conta de jogo</h1>
                            <form method="POST" action="/account/game-accounts" class="w-full flex flex-col">
                                @csrf
                                <div class="flex flex-col w-full gap-y-2">
                                    <div class="flex flex-col w-full">
                                        <div class="relative z-0 w-full">
                                            <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="userid-input" name="userid" value="">
                                            <label for="userid" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">User ID<span class="ml-1 text-brand-red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-full">
                                        <div class="relative z-0 w-full">
                                            <input type="password" placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="password-input" name="user_pass" value="">
                                            <label for="user_pass" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Password<span class="ml-1 text-brand-red">*</span></label>
                                            <button type="button" class="absolute right-4 top-3 focus:outline-none">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M8.56818 4.70906C9.0375 4.59921 9.518 4.54429 10 4.54543C14.7727 4.54543 17.5 9.99997 17.5 9.99997C17.0861 10.7742 16.5925 11.5032 16.0273 12.175M11.4455 11.4454C11.2582 11.6464 11.0324 11.8076 10.7815 11.9194C10.5306 12.0312 10.2597 12.0913 9.98506 12.0961C9.71042 12.101 9.43761 12.0505 9.18292 11.9476C8.92822 11.8447 8.69686 11.6916 8.50262 11.4973C8.30839 11.3031 8.15527 11.0718 8.05239 10.8171C7.94952 10.5624 7.899 10.2896 7.90384 10.0149C7.90869 9.74027 7.9688 9.46941 8.0806 9.2185C8.19239 8.9676 8.35358 8.74178 8.55455 8.55452M14.05 14.05C12.8845 14.9384 11.4653 15.4306 10 15.4545C5.22727 15.4545 2.5 9.99997 2.5 9.99997C3.34811 8.41945 4.52441 7.03857 5.95 5.94997L14.05 14.05Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M2.5 2.5L17.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" data-testid="create-account-button" class="w-full py-3 px-6 text-white bg-brand-main rounded-md hover:bg-brand-green focus:ring-2 focus:ring-brand-main focus:outline-none disabled:bg-gray-300 disabled:cursor-not-allowed transition-all w-full mt-4 font-robotoCond uppercase text-md">criar conta de jogo</button>
                            </form>
                        </div>
                    </div>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-md p-5 shadow-sm text-sm leading-snug">
                        <div class="max-w-lg flex flex-col items-left mb-6">
                            <h1 class="text-large-semi uppercase mb-3 font-robotoCond">Lista de contas de jogo</h1>
                            <div class="flex flex-col gap-y-4">
                                @if($gameAccounts->count() > 0)
                                    @foreach($gameAccounts as $account)
                                        <div class="flex items-center justify-between p-4 small:border-b border-gray-200">
                                            <div class="flex flex-col justify-center">
                                                <span class="font-semibold uppercase font-robotoCond">Usuário</span>
                                                <span>{{ $account->userid }}</span>
                                            </div>
                                            <div class="flex gap-2">
                                                <button onclick="openPasswordModal('{{ $account->userid }}')" class="transition-fg relative inline-flex items-center justify-center overflow-hidden border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored after:button-inverted-gradient hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 w-full font-robotoCond uppercase sm:w-auto py-3 px-6 font-medium text-brand-main bg-white border-brand-main rounded-md hover:bg-brand-orange hover:text-white transition-all">Alterar Senha</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-600">Nenhuma conta de jogo encontrada. Crie uma nova conta acima!</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Alteração de Senha -->
                    <div id="passwordModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg">
                            <h2 class="text-large-semi uppercase mb-4">Change Password</h2>
                            <p class="text-sm text-gray-600 mb-4">Game account: <span id="modalUsername" class="font-semibold"></span></p>
                            <form method="POST" action="/account/game-accounts/change-password">
                                @csrf
                                <input type="hidden" name="userid" id="modalUseridInput">
                                <label for="new-password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <div class="relative">
                                    <input class="caret-ui-fg-base bg-ui-bg-field hover:bg-ui-bg-field-hover border-ui-border-base shadow-buttons-neutral placeholder-ui-fg-muted text-ui-fg-base transition-fg relative w-full appearance-none rounded-md border outline-none focus:border-ui-border-interactive focus:shadow-borders-active disabled:text-ui-fg-disabled disabled:!bg-ui-bg-disabled disabled:!border-ui-border-base disabled:placeholder-ui-fg-disabled disabled:cursor-not-allowed disabled:!shadow-none aria-[invalid=true]:!border-ui-border-error aria-[invalid=true]:focus:!shadow-borders-error invalid:!border-ui-border-error invalid:focus:!shadow-borders-error [&::--webkit-search-cancel-button]:hidden [&::-webkit-search-cancel-button]:hidden [&::-webkit-search-decoration]:hidden txt-compact-medium h-10 px-3 py-[9px] pr-11" id="new-password" required="" type="password" name="new_password" value="">
                                    <div class="absolute bottom-0 right-0 flex items-center justify-center h-10 w-11">
                                        <button class="text-ui-fg-muted hover:text-ui-fg-base focus:text-ui-fg-base focus:shadow-borders-interactive-w-focus active:text-ui-fg-base h-fit w-fit rounded-sm outline-none transition-all" type="button" onclick="togglePassword()">
                                            <span class="sr-only">Show password</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                                                <g fill="currentColor" clip-path="url(#a)">
                                                    <path d="M7.5 12.833c-3.558 0-5.725-2.48-6.7-3.96a2.49 2.49 0 0 1 0-2.747c.975-1.48 3.142-3.96 6.7-3.96s5.725 2.48 6.7 3.96a2.49 2.49 0 0 1 0 2.746c-.975 1.48-3.142 3.961-6.7 3.961m0-9.333c-2.934 0-4.76 2.106-5.588 3.36a1.18 1.18 0 0 0 0 1.28C2.74 9.393 4.566 11.5 7.5 11.5s4.76-2.106 5.588-3.36a1.18 1.18 0 0 0 0-1.28C12.26 5.607 10.434 3.5 7.5 3.5"></path>
                                                    <path d="M7.5 10.389a2.889 2.889 0 1 0 0-5.778 2.889 2.889 0 0 0 0 5.778"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="a">
                                                        <path fill="#fff" d="M0 0h15v15H0z"></path>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-4 mt-4">
                                    <button type="button" onclick="closePasswordModal()" class="transition-fg relative inline-flex w-fit items-center justify-center overflow-hidden border outline-none disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored border-ui-border-loud after:button-inverted-gradient hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 py-3 px-6 font-medium text-white bg-brand-red rounded-md hover:bg-brand-darkred focus:ring-2 focus:ring-brand-main focus:outline-none disabled:bg-gray-300 disabled:cursor-not-allowed transition-all border-none">Cancel</button>
                                    <button type="submit" class="transition-fg relative inline-flex w-fit items-center justify-center overflow-hidden border outline-none disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored border-ui-border-loud after:button-inverted-gradient hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 py-3 px-6 font-medium text-white bg-brand-green rounded-md hover:bg-brand-darkgreen focus:ring-2 focus:ring-brand-main focus:outline-none disabled:bg-gray-300 disabled:cursor-not-allowed transition-all border-none">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        function openPasswordModal(userid) {
                            document.getElementById('passwordModal').classList.remove('hidden');
                            document.getElementById('modalUsername').textContent = userid;
                            document.getElementById('modalUseridInput').value = userid;
                        }

                        function closePasswordModal() {
                            document.getElementById('passwordModal').classList.add('hidden');
                            document.getElementById('new-password').value = '';
                        }

                        function togglePassword() {
                            const passwordInput = document.getElementById('new-password');
                            if (passwordInput.type === 'password') {
                                passwordInput.type = 'text';
                            } else {
                                passwordInput.type = 'password';
                            }
                        }

                        // Fechar modal ao clicar fora dele
                        document.getElementById('passwordModal').addEventListener('click', function(e) {
                            if (e.target === this) {
                                closePasswordModal();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection