<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/2fa', [TwoFactorAuthController::class, 'show2faForm'])->name('2fa.form');
Route::post('/2fa', [TwoFactorAuthController::class, 'enable2fa'])->name('2fa.enable');

Route::get('/2fa/verify', [TwoFactorAuthController::class, 'verify2faForm'])->name('2fa.verify');
Route::post('/2fa/verify', [TwoFactorAuthController::class, 'verify2fa'])->name('2fa.postVerify');

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
