<?php

use App\Livewire\Auth\{Login, Register};
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

Route::get('/', Welcome::class)->name('dashboard');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/login', Login::class)->name('auth.login');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', Home::class)->name('home');
    Route::get('/logout', fn () => auth()->logout())->name('logout');


//Route::get('/categoria', Category::class)->name('categoria');
    //    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    //
    //    #region Questions routes
    //    Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
    //    Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('question.edit');
    //
    //    Route::post('/questions/store', [QuestionController::class, 'store'])->name('question.store');
    //    Route::post('/questions/like/{question}', Question\LikeController::class)->name('question.like');
    //    Route::post('/questions/unlike/{question}', Question\UnlikeController::class)->name('question.unlike');
    //
    //    Route::put('/questions/publish/{question}', Question\PublishController::class)->name('question.publish');
    //    Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('question.update');
    //
    //    Route::patch('/questions/{question}/archive', [QuestionController::class, 'archive'])->name('question.archive');
    //    Route::patch('/questions/{question}/restore', [QuestionController::class, 'restore'])->name('question.restore');
    //
    //    Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');
    //
    //    #endregion
    //
    //    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
