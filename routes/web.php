<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Page Route
// Route::get('/', [PageController::class, 'blankPage'])->middleware('verified');

Route::get('/page-blank', [PageController::class, 'blankPage']);
Route::get('/page-collapse', [PageController::class, 'collapsePage']);

// locale route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

// Auth::routes(['verify' => true]);


Route::get('/login', [IndexController::class, 'index'])->name('login');
Route::post('/login-auth', [IndexController::class, 'auth'])->name('auth');
Route::get('/logout', [IndexController::class, 'logout'])->name('logout');
Route::get('/register', [IndexController::class, 'register'])->name('register');

Route::get('/', [IndexController::class, 'dashboard'])->name('dashboard');

