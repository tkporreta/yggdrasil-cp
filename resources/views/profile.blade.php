@extends('layouts.app')

@section('content')
<div class="flex-1 small:py-12" data-testid="account-page">
    <div class="flex-1 h-full max-w-5xl mx-auto bg-white flex flex-col">
        <div class="grid grid-cols-1 small:grid-cols-[240px_1fr] py-12">
            <!-- Sidebar -->
            <div>
                <div class="small:hidden" data-testid="mobile-account-nav">
                    <a class="flex items-center gap-x-2 text-small-regular py-2" data-testid="account-main-link" href="/account">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="transform rotate-90">
                            <path d="M4 6L8 10L12 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span>Global Account</span>
                    </a>
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
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="ygg-points-link" href="/account/ygg-points">Ygg Points</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="votes-link" href="/account/votes">Votos</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="roulette-link" href="/account/roulette">Roleta</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="orders-link" href="/account/orders">Transactions</a></li>
                                <li><a class="text-brand-main hover:underline hover:text-ui-fg-base font-robotoCond uppercase" data-testid="download-link" href="/download">Download</a></li>
                                <li><a class="hover:underline hover:text-ui-fg-base font-semibold uppercase font-robotoCond text-brand-main" data-testid="profile-link" href="/account/profile">Profile</a></li>
                                <li>
                                    <form method="POST" action="/logout">
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
                <div class="w-full" data-testid="profile-page-wrapper">
                    <div class="mb-8 flex flex-col gap-y-4">
                        <h1 class="text-2xl-semi">Profile</h1>
                        <p class="text-base-regular">View and update your profile information, including your name, email, and phone number. You can also update your billing address, or change your password.</p>
                    </div>
                    <div class="flex flex-col gap-y-8 w-full">
                        <!-- Name Editor -->
                        <form action="javascript:throw new Error('A React form was unexpectedly submitted. If you called form.submit() manually, consider using form.requestSubmit() instead. If you\'re trying to use event.stopPropagation() in a submit event handler, consider also calling event.preventDefault().')" class="w-full overflow-visible">
                            <div class="text-small-regular" data-testid="account-name-editor">
                                <div class="flex items-end justify-between">
                                    <div class="flex flex-col">
                                        <span class="uppercase text-ui-fg-base">Name</span>
                                        <div class="flex items-center flex-1 basis-0 justify-end gap-x-4">
                                            <span class="font-semibold" data-testid="current-info">{{ session('first_name') }} {{ session('last_name') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" data-testid="edit-button" data-active="false" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-neutral text-ui-fg-base border-ui-border-base bg-ui-button-neutral after:button-neutral-gradient hover:bg-ui-button-neutral-hover hover:after:button-neutral-hover-gradient active:bg-ui-button-neutral-pressed active:after:button-neutral-pressed-gradient focus:shadow-buttons-neutral-focus txt-compact-small-plus gap-x-1 px-2 w-[100px] min-h-[25px] py-1">Edit</button>
                                    </div>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="success-message" id="headlessui-disclosure-panel-:r0:" data-headlessui-state="">
                                    <span class="bg-ui-tag-green-bg text-ui-tag-green-text [&amp;_svg]:text-ui-tag-green-icon border-ui-tag-green-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span>Name updated succesfully</span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="error-message" id="headlessui-disclosure-panel-:r1:" data-headlessui-state="">
                                    <span class="bg-ui-tag-red-bg text-ui-tag-red-text [&amp;_svg]:text-ui-tag-red-icon border-ui-tag-red-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span>An error occurred, please try again</span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-visible max-h-0 opacity-0" id="headlessui-disclosure-panel-:r2:" data-headlessui-state="">
                                    <div class="flex flex-col gap-y-2 py-4">
                                        <div>
                                            <div class="grid grid-cols-2 gap-x-4">
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="first-name-input" value="{{ session('first_name') }}" name="first_name">
                                                        <label for="first_name" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">First name<span class="ml-1 text-brand-red">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="last-name-input" value="{{ session('last_name') }}" name="last_name">
                                                        <label for="last_name" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Last name<span class="ml-1 text-brand-red">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <button type="submit" data-testid="save-button" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored text-ui-fg-on-inverted border-ui-border-loud bg-ui-button-inverted after:button-inverted-gradient hover:bg-ui-button-inverted-hover hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 px-2 py-[5px] w-full small:max-w-[140px]">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="w-full h-px bg-gray-200"></div>

                        <!-- Email Editor -->
                        <form action="javascript:throw new Error('A React form was unexpectedly submitted. If you called form.submit() manually, consider using form.requestSubmit() instead. If you\'re trying to use event.stopPropagation() in a submit event handler, consider also calling event.preventDefault().')" class="w-full">
                            <div class="text-small-regular" data-testid="account-email-editor">
                                <div class="flex items-end justify-between">
                                    <div class="flex flex-col">
                                        <span class="uppercase text-ui-fg-base">Email</span>
                                        <div class="flex items-center flex-1 basis-0 justify-end gap-x-4">
                                            <span class="font-semibold" data-testid="current-info">{{ session('email') }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" data-testid="edit-button" data-active="false" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-neutral text-ui-fg-base border-ui-border-base bg-ui-button-neutral after:button-neutral-gradient hover:bg-ui-button-neutral-hover hover:after:button-neutral-hover-gradient active:bg-ui-button-neutral-pressed active:after:button-neutral-pressed-gradient focus:shadow-buttons-neutral-focus txt-compact-small-plus gap-x-1 px-2 w-[100px] min-h-[25px] py-1">Edit</button>
                                    </div>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="success-message" id="headlessui-disclosure-panel-:r3:" data-headlessui-state="">
                                    <span class="bg-ui-tag-green-bg text-ui-tag-green-text [&amp;_svg]:text-ui-tag-green-icon border-ui-tag-green-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span>Email updated succesfully</span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="error-message" id="headlessui-disclosure-panel-:r4:" data-headlessui-state="">
                                    <span class="bg-ui-tag-red-bg text-ui-tag-red-text [&amp;_svg]:text-ui-tag-red-icon border-ui-tag-red-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span></span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-visible max-h-0 opacity-0" id="headlessui-disclosure-panel-:r5:" data-headlessui-state="">
                                    <div class="flex flex-col gap-y-2 py-4">
                                        <div>
                                            <div class="grid grid-cols-1 gap-y-2">
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" autocomplete="email" data-testid="email-input" type="email" value="{{ session('email') }}" name="email">
                                                        <label for="email" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Email<span class="ml-1 text-brand-red">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <button type="submit" data-testid="save-button" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored text-ui-fg-on-inverted border-ui-border-loud bg-ui-button-inverted after:button-inverted-gradient hover:bg-ui-button-inverted-hover hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 px-2 py-[5px] w-full small:max-w-[140px]">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="w-full h-px bg-gray-200"></div>

                        <!-- Phone Editor -->
                        <form action="javascript:throw new Error('A React form was unexpectedly submitted. If you called form.submit() manually, consider using form.requestSubmit() instead. If you\'re trying to use event.stopPropagation() in a submit event handler, consider also calling event.preventDefault().')" class="w-full">
                            <div class="text-small-regular" data-testid="account-phone-editor">
                                <div class="flex items-end justify-between">
                                    <div class="flex flex-col">
                                        <span class="uppercase text-ui-fg-base">Phone</span>
                                        <div class="flex items-center flex-1 basis-0 justify-end gap-x-4">
                                            <span class="font-semibold" data-testid="current-info">{{ session('phone') ?: 'Not provided' }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" data-testid="edit-button" data-active="false" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-neutral text-ui-fg-base border-ui-border-base bg-ui-button-neutral after:button-neutral-gradient hover:bg-ui-button-neutral-hover hover:after:button-neutral-hover-gradient active:bg-ui-button-neutral-pressed active:after:button-neutral-pressed-gradient focus:shadow-buttons-neutral-focus txt-compact-small-plus gap-x-1 px-2 w-[100px] min-h-[25px] py-1">Edit</button>
                                    </div>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="success-message" id="headlessui-disclosure-panel-:r6:" data-headlessui-state="">
                                    <span class="bg-ui-tag-green-bg text-ui-tag-green-text [&amp;_svg]:text-ui-tag-green-icon border-ui-tag-green-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span>Phone updated succesfully</span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="error-message" id="headlessui-disclosure-panel-:r7:" data-headlessui-state="">
                                    <span class="bg-ui-tag-red-bg text-ui-tag-red-text [&amp;_svg]:text-ui-tag-red-icon border-ui-tag-red-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span></span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-visible max-h-0 opacity-0" id="headlessui-disclosure-panel-:r8:" data-headlessui-state="">
                                    <div class="flex flex-col gap-y-2 py-4">
                                        <div>
                                            <div class="grid grid-cols-1 gap-y-2">
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" autocomplete="phone" data-testid="phone-input" type="phone" value="{{ session('phone') }}" name="phone">
                                                        <label for="phone" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Phone<span class="ml-1 text-brand-red">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <button type="submit" data-testid="save-button" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored text-ui-fg-on-inverted border-ui-border-loud bg-ui-button-inverted after:button-inverted-gradient hover:bg-ui-button-inverted-hover hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 px-2 py-[5px] w-full small:max-w-[140px]">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="w-full h-px bg-gray-200"></div>

                        <!-- Password Editor -->
                        <form action="javascript:throw new Error('A React form was unexpectedly submitted. If you called form.submit() manually, consider using form.requestSubmit() instead. If you\'re trying to use event.stopPropagation() in a submit event handler, consider also calling event.preventDefault().')" class="w-full">
                            <div class="text-small-regular" data-testid="account-password-editor">
                                <div class="flex items-end justify-between">
                                    <div class="flex flex-col">
                                        <span class="uppercase text-ui-fg-base">Password</span>
                                        <div class="flex items-center flex-1 basis-0 justify-end gap-x-4">
                                            <span>The password is not shown for security reasons</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" data-testid="edit-button" data-active="false" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-neutral text-ui-fg-base border-ui-border-base bg-ui-button-neutral after:button-neutral-gradient hover:bg-ui-button-neutral-hover hover:after:button-neutral-hover-gradient active:bg-ui-button-neutral-pressed active:after:button-neutral-pressed-gradient focus:shadow-buttons-neutral-focus txt-compact-small-plus gap-x-1 px-2 w-[100px] min-h-[25px] py-1">Edit</button>
                                    </div>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="success-message" id="headlessui-disclosure-panel-:r9:" data-headlessui-state="">
                                    <span class="bg-ui-tag-green-bg text-ui-tag-green-text [&amp;_svg]:text-ui-tag-green-icon border-ui-tag-green-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span>Password updated succesfully</span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-hidden max-h-0 opacity-0" data-testid="error-message" id="headlessui-disclosure-panel-:ra:" data-headlessui-state="">
                                    <span class="bg-ui-tag-red-bg text-ui-tag-red-text [&amp;_svg]:text-ui-tag-red-icon border-ui-tag-red-border inline-flex items-center gap-x-0.5 border txt-compact-small-plus rounded-md p-2 my-4">
                                        <span></span>
                                    </span>
                                </div>
                                <div class="transition-[max-height,opacity] duration-300 ease-in-out overflow-visible max-h-0 opacity-0" id="headlessui-disclosure-panel-:rb:" data-headlessui-state="">
                                    <div class="flex flex-col gap-y-2 py-4">
                                        <div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="old-password-input" type="password" name="old_password">
                                                        <label for="old_password" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Old password<span class="ml-1 text-brand-red">*</span></label>
                                                        <button type="button" class="absolute right-4 top-3 focus:outline-none">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.56818 4.70906C9.0375 4.59921 9.518 4.54429 10 4.54543C14.7727 4.54543 17.5 9.99997 17.5 9.99997C17.0861 10.7742 16.5925 11.5032 16.0273 12.175M11.4455 11.4454C11.2582 11.6464 11.0324 11.8076 10.7815 11.9194C10.5306 12.0312 10.2597 12.0913 9.98506 12.0961C9.71042 12.101 9.43761 12.0505 9.18292 11.9476C8.92822 11.8447 8.69686 11.6916 8.50262 11.4973C8.30839 11.3031 8.15527 11.0718 8.05239 10.8171C7.94952 10.5624 7.899 10.2896 7.90384 10.0149C7.90869 9.74027 7.9688 9.46941 8.0806 9.2185C8.19239 8.9676 8.35358 8.74178 8.55455 8.55452M14.05 14.05C12.8845 14.9384 11.4653 15.4306 10 15.4545C5.22727 15.4545 2.5 9.99997 2.5 9.99997C3.34811 8.41945 4.52441 7.03857 5.95 5.94997L14.05 14.05Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M2.5 2.5L17.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="new-password-input" type="password" name="new_password">
                                                        <label for="new_password" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">New password<span class="ml-1 text-brand-red">*</span></label>
                                                        <button type="button" class="absolute right-4 top-3 focus:outline-none">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.56818 4.70906C9.0375 4.59921 9.518 4.54429 10 4.54543C14.7727 4.54543 17.5 9.99997 17.5 9.99997C17.0861 10.7742 16.5925 11.5032 16.0273 12.175M11.4455 11.4454C11.2582 11.6464 11.0324 11.8076 10.7815 11.9194C10.5306 12.0312 10.2597 12.0913 9.98506 12.0961C9.71042 12.101 9.43761 12.0505 9.18292 11.9476C8.92822 11.8447 8.69686 11.6916 8.50262 11.4973C8.30839 11.3031 8.15527 11.0718 8.05239 10.8171C7.94952 10.5624 7.899 10.2896 7.90384 10.0149C7.90869 9.74027 7.9688 9.46941 8.0806 9.2185C8.19239 8.9676 8.35358 8.74178 8.55455 8.55452M14.05 14.05C12.8845 14.9384 11.4653 15.4306 10 15.4545C5.22727 15.4545 2.5 9.99997 2.5 9.99997C3.34811 8.41945 4.52441 7.03857 5.95 5.94997L14.05 14.05Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M2.5 2.5L17.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="flex flex-col w-full">
                                                    <div class="relative z-0 w-full">
                                                        <input placeholder=" " required="" class="peer block w-full rounded-md border border-brand-main bg-white py-3 px-4 text-base text-brand-main placeholder-transparent focus:outline-none focus:ring-2" data-testid="confirm-password-input" type="password" name="confirm_password">
                                                        <label for="confirm_password" class="absolute left-4 top-3 text-sm text-brand-main transition-all duration-300 peer-placeholder-shown:top-6 peer-focus:left-6 peer-focus:text-brand-main">Confirm password<span class="ml-1 text-brand-red">*</span></label>
                                                        <button type="button" class="absolute right-4 top-3 focus:outline-none">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M8.56818 4.70906C9.0375 4.59921 9.518 4.54429 10 4.54543C14.7727 4.54543 17.5 9.99997 17.5 9.99997C17.0861 10.7742 16.5925 11.5032 16.0273 12.175M11.4455 11.4454C11.2582 11.6464 11.0324 11.8076 10.7815 11.9194C10.5306 12.0312 10.2597 12.0913 9.98506 12.0961C9.71042 12.101 9.43761 12.0505 9.18292 11.9476C8.92822 11.8447 8.69686 11.6916 8.50262 11.4973C8.30839 11.3031 8.15527 11.0718 8.05239 10.8171C7.94952 10.5624 7.899 10.2896 7.90384 10.0149C7.90869 9.74027 7.9688 9.46941 8.0806 9.2185C8.19239 8.9676 8.35358 8.74178 8.55455 8.55452M14.05 14.05C12.8845 14.9384 11.4653 15.4306 10 15.4545C5.22727 15.4545 2.5 9.99997 2.5 9.99997C3.34811 8.41945 4.52441 7.03857 5.95 5.94997L14.05 14.05Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path d="M2.5 2.5L17.5 17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-end mt-2">
                                            <button type="submit" data-testid="save-button" class="transition-fg relative inline-flex items-center justify-center overflow-hidden rounded-md border outline-none disabled:bg-ui-bg-disabled disabled:border-ui-border-base disabled:text-ui-fg-disabled disabled:!shadow-none disabled:after:hidden after:absolute after:inset-0 after:content-[''] shadow-buttons-colored text-ui-fg-on-inverted border-ui-border-loud bg-ui-button-inverted after:button-inverted-gradient hover:bg-ui-button-inverted-hover hover:after:button-inverted-hover-gradient active:bg-ui-button-inverted-pressed active:after:button-inverted-pressed-gradient focus:!shadow-buttons-colored-focus txt-compact-small-plus gap-x-1 px-2 py-[5px] w-full small:max-w-[140px]">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="flex flex-col small:flex-row items-end justify-start small:border-t border-gray-200 py-12 gap-2">
            <div>
                <h3 class="text-3xl font-core leading-tight uppercase">Got questions?</h3>
                <span class="text-lg font-robotoCond text-ui-fg-base">You can find frequently asked questions and answers on our community:</span>
            </div>
            <div>
                <a href="https://discord.gg/mythofyggdrasil" target="_blank" rel="noreferrer" class="text-lg font-robotoCond text-ui-fg-base hover:underline flex gap-2 items-center font-bold uppercase justify-center">
                    join our Discord
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none">
                        <path fill="#5865F2" d="M9.996 9.58c-.739 0-1.348-.678-1.348-1.511 0-.834.597-1.512 1.348-1.512s1.36.685 1.348 1.512c-.011.826-.59 1.511-1.348 1.511m-4.984 0c-.739 0-1.348-.678-1.348-1.511 0-.834.597-1.512 1.348-1.512s1.36.685 1.349 1.512c-.012.826-.598 1.511-1.349 1.511m7.684-6.85a12.4 12.4 0 0 0-3.052-.946.05.05 0 0 0-.05.023q-.21.38-.38.78a11.4 11.4 0 0 0-3.428 0 8 8 0 0 0-.386-.78.05.05 0 0 0-.05-.023c-1.054.181-2.08.5-3.052.946a.04.04 0 0 0-.02.017C.334 5.652-.199 8.486.062 11.287a.05.05 0 0 0 .02.034 12.4 12.4 0 0 0 3.744 1.894.05.05 0 0 0 .053-.017q.434-.591.766-1.247a.05.05 0 0 0-.027-.065 8 8 0 0 1-1.17-.558.05.05 0 0 1-.025-.04.05.05 0 0 1 .02-.042c.083-.06.158-.12.233-.182a.05.05 0 0 1 .048-.007c2.454 1.12 5.112 1.12 7.537 0a.05.05 0 0 1 .05.006 5 5 0 0 0 .233.182.05.05 0 0 1 .02.042.05.05 0 0 1-.024.04 7.7 7.7 0 0 1-1.166.555.1.1 0 0 0-.017.01.05.05 0 0 0-.014.037q0 .01.005.019.337.651.765 1.246a.047.047 0 0 0 .053.018 12.4 12.4 0 0 0 3.75-1.893.05.05 0 0 0 .02-.034c.312-3.235-.524-6.046-2.217-8.54a.04.04 0 0 0-.023-.015"
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection