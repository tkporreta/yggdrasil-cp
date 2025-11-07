<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\RouletteController;
use App\Http\Controllers\Admin\RouletteController as AdminRouletteController;

Route::get('/', function () {
    return view('home');
});

// Blog routes (public)
Route::get('/blog', [NewsController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [NewsController::class, 'blogShow'])->name('blog.show');

// Admin routes (protected by custom session check in controller)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('news', NewsController::class);
    
    // Vote management routes
    Route::get('vote', [VoteController::class, 'adminIndex'])->name('vote.index');
    Route::get('vote/create', [VoteController::class, 'create'])->name('vote.create');
    Route::post('vote', [VoteController::class, 'store'])->name('vote.store');
    Route::get('vote/{vote}/edit', [VoteController::class, 'edit'])->name('vote.edit');
    Route::put('vote/{vote}', [VoteController::class, 'update'])->name('vote.update');
    Route::delete('vote/{vote}', [VoteController::class, 'destroy'])->name('vote.destroy');
    
    // Donation management routes
    Route::get('donations', [DonationController::class, 'adminIndex'])->name('donations.index');
    Route::post('donations/{id}/process', [DonationController::class, 'processTransaction'])->name('donations.process');
    
    // Roulette management routes
    Route::get('roulette', [AdminRouletteController::class, 'index'])->name('roulette.index');
    Route::post('roulette', [AdminRouletteController::class, 'index'])->name('roulette.index'); // Processa configurações
    Route::get('roulette/create', [AdminRouletteController::class, 'create'])->name('roulette.create');
    Route::post('roulette/store', [AdminRouletteController::class, 'store'])->name('roulette.store');
    Route::post('roulette/{id}/toggle', [AdminRouletteController::class, 'toggleStatus'])->name('roulette.toggle');
    Route::get('roulette/{id}/edit', [AdminRouletteController::class, 'edit'])->name('roulette.edit');
    Route::put('roulette/{id}', [AdminRouletteController::class, 'update'])->name('roulette.update');
    Route::delete('roulette/{id}', [AdminRouletteController::class, 'destroy'])->name('roulette.destroy');
});

Route::get('/account', [AccountController::class, 'show']);
Route::get('/account', [AccountController::class, 'show'])->name('login'); // Define login route
Route::post('/account', [AccountController::class, 'login'])->middleware('throttle:5,1'); // Max 5 tentativas por minuto
Route::post('/account/register', [AccountController::class, 'register'])->middleware('throttle:3,1'); // Max 3 registros por minuto
Route::get('/account/profile', [AccountController::class, 'profile']);
Route::get('/account/game-accounts', [AccountController::class, 'gameAccounts']);
Route::post('/account/game-accounts', [AccountController::class, 'createGameAccount'])->middleware('throttle:5,1');
Route::post('/account/game-accounts/change-password', [AccountController::class, 'changeGameAccountPassword'])->middleware('throttle:5,1');
Route::get('/account/ygg-points', [DonationController::class, 'index'])->name('donation.index');
Route::post('/donation/create-payment', [DonationController::class, 'createPayment'])->name('donation.create')->middleware('throttle:10,1');
Route::post('/donation/webhook', [DonationController::class, 'webhook'])->name('donation.webhook');
Route::get('/account/votes', [VoteController::class, 'index'])->name('vote.index');
Route::post('/account/votes/{id}', [VoteController::class, 'vote'])->name('vote.submit')->middleware('throttle:20,1');
Route::get('/account/roulette', [RouletteController::class, 'index'])->name('roulette.index');
Route::post('/account/roulette/spin', [RouletteController::class, 'spin'])->name('roulette.spin')->middleware('throttle:20,1');
Route::get('/account/roulette/history', [RouletteController::class, 'history'])->name('roulette.history');
Route::get('/account/orders', [AccountController::class, 'orders']);
Route::post('/logout', [AccountController::class, 'logout']);

Route::get('/download', function () {
    return view('download');
});

Route::get('/us', function () {
    return view('us');
});
