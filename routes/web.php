<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PrivilegesController;
use App\Http\Controllers\UserstatusController;
use App\Http\Controllers\DefaultstatusController;
use App\Http\Controllers\ResourcetypeController;
use App\Http\Controllers\QuiztypeController;
use App\Http\Controllers\ClassesController;

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

Route::prefix('defaultstatus')->as('defaultstatus')->group(function () {
    Route::get('/', [DefaultstatusController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [DefaultstatusController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [DefaultstatusController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [DefaultstatusController::class, 'destroy'])->name('-delete');
});

Route::prefix('resourcetype')->as('resourcetype')->group(function () {
    Route::get('/', [ResourcetypeController::class, 'index'])->name('');
    // Route::get('/create', [ResourcetypeController::class, 'create'])->name('-add');
    Route::post('/store', [ResourcetypeController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [ResourcetypeController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [ResourcetypeController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [ResourcetypeController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [ResourcetypeController::class, 'destroy'])->name('-delete');
});

Route::prefix('quiztype')->as('quiztype')->group(function () {
    Route::get('/', [QuiztypeController::class, 'index'])->name('');
    // Route::get('/create', [QuiztypeController::class, 'create'])->name('-add');
    Route::post('/store', [QuiztypeController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [QuiztypeController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [QuiztypeController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [QuiztypeController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [QuiztypeController::class, 'destroy'])->name('-delete');
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

Route::prefix('classes')->as('classes')->group(function () {
    Route::get('/', [ClassesController::class, 'index'])->name('');
    Route::get('/create', [ClassesController::class, 'create'])->name('-add');
    Route::post('/store', [ClassesController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [ClassesController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [ClassesController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [ClassesController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [ClassesController::class, 'destroy'])->name('-delete');
});


