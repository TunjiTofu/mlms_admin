<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PrivilegesController;
use App\Http\Controllers\UserstatusController;

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

Route::prefix('privileges')->as('privileges')->group(function () {
    Route::get('/', [PrivilegesController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [PrivilegesController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [PrivilegesController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [PrivilegesController::class, 'destroy'])->name('-delete');
});

Route::prefix('userstatus')->as('userstatus')->group(function () {
    Route::get('/', [UserstatusController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [UserstatusController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [UserstatusController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [UserstatusController::class, 'destroy'])->name('-delete');
});

Route::prefix('users')->as('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('');
    Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [UsersController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [UsersController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [UsersController::class, 'destroy'])->name('-delete');
});


