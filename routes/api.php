<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

Route::get('transactions', [TransactionController::class, 'index']);
Route::post('transactions', [TransactionController::class, 'store']);
Route::get('transactions/total-amount', [TransactionController::class, 'getTotalAmount']);
Route::get('transactions/total-add-monthly', [TransactionController::class, 'getTotalAddYearly']);
Route::get('transactions/total-withdraw-monthly', [TransactionController::class, 'getTotalWithdrawYearly']);
Route::get('transactions/report', [TransactionController::class, 'getReport']);
Route::get('transactions/monthly-report', [TransactionController::class, 'getMonthlyReport']);
Route::get('transactions/history', [TransactionController::class, 'getTransactionHistory']);
Route::post('transactions/history', [TransactionController::class, 'addTransactionHistory']);