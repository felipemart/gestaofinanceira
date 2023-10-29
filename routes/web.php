<?php

use App\Livewire\Auth\{Login, Password\Recovery, Register};
use App\Livewire\{Category, Home, Welcome};
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

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/password/recovery', Recovery::class)->name('password.recovery');
Route::get('/paasword/reset', fn () => 'oi')->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/', Welcome::class)->name('dashboard');
    Route::get('/home', Home::class)->name('home');
    Route::get('/logout', fn () => auth()->logout())->name('logout');
});
