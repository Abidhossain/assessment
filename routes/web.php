<?php

use App\Http\Controllers\Deposit\DepositController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\withdrawal\WithdrawalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Check if a user is authenticated
    if (auth()->check()) {
        // If authenticated, redirect to the dashboard
        return redirect('/dashboard');
    }

    return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return redirect('transactions');
    })->name('dashboard');
    Route::get('withdrawal', [WithdrawalController::class, 'index'])->name('withdraw.index');
    Route::post('withdrawal', [WithdrawalController::class, 'store'])->name('withdraw.store');
    Route::get('deposit', [DepositController::class, 'index'])->name('deposit.index');
    Route::post('deposit', [DepositController::class, 'store'])->name('deposit.store');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
});

require __DIR__ . '/auth.php';
