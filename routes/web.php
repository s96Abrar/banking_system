<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'loginView'])->name('login');

Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/login', [UserController::class, 'login'])->name('users.login');

Route::middleware(['auth'])->group(function() {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');

    Route::get('/deposit', [TransactionController::class, 'depositIndex'])->name('deposits.index');
    Route::post('/deposit', [TransactionController::class, 'depositStore'])->name('deposits.store');

    Route::get('/withdrawal', [TransactionController::class, 'withdrawIndex'])->name('withdraw.index');
    Route::post('/withdrawal', [TransactionController::class, 'withdrawStore'])->name('withdraw.store');

    Route::post('logout', [UserController::class, 'destroy'])->name('logout');
});
