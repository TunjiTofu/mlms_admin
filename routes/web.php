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
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\QuizController;


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

// PRIVILEGES ROUTES
Route::prefix('privileges')->as('privileges')->group(function () {
    Route::get('/', [PrivilegesController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [PrivilegesController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [PrivilegesController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [PrivilegesController::class, 'destroy'])->name('-delete');
});

// USER STATUS ROUTES
Route::prefix('userstatus')->as('userstatus')->group(function () {
    Route::get('/', [UserstatusController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [UserstatusController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [UserstatusController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [UserstatusController::class, 'destroy'])->name('-delete');
});

// DEFAULT STATUS ROUTES
Route::prefix('defaultstatus')->as('defaultstatus')->group(function () {
    Route::get('/', [DefaultstatusController::class, 'index'])->name('');
    // Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [DefaultstatusController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [DefaultstatusController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [DefaultstatusController::class, 'destroy'])->name('-delete');
});

// RESOURCE TYPES ROUTES
Route::prefix('resourcetype')->as('resourcetype')->group(function () {
    Route::get('/', [ResourcetypeController::class, 'index'])->name('');
    // Route::get('/create', [ResourcetypeController::class, 'create'])->name('-add');
    Route::post('/store', [ResourcetypeController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [ResourcetypeController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [ResourcetypeController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [ResourcetypeController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [ResourcetypeController::class, 'destroy'])->name('-delete');
});

// QUIZ TYPES ROUTES
Route::prefix('quiztype')->as('quiztype')->group(function () {
    Route::get('/', [QuiztypeController::class, 'index'])->name('');
    // Route::get('/create', [QuiztypeController::class, 'create'])->name('-add');
    Route::post('/store', [QuiztypeController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [QuiztypeController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [QuiztypeController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [QuiztypeController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [QuiztypeController::class, 'destroy'])->name('-delete');
});

// USERS ROUTES
Route::prefix('users')->as('users')->group(function () {
    Route::get('/', [UsersController::class, 'index'])->name('');
    Route::get('/create', [UsersController::class, 'create'])->name('-add');
    Route::post('/store', [UsersController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [UsersController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [UsersController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [UsersController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [UsersController::class, 'destroy'])->name('-delete');
});

// CLASSES ROUTES
Route::prefix('classes')->as('classes')->group(function () {
    Route::get('/', [ClassesController::class, 'index'])->name('');
    Route::get('/create', [ClassesController::class, 'create'])->name('-add');
    Route::post('/store', [ClassesController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [ClassesController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [ClassesController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [ClassesController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [ClassesController::class, 'destroy'])->name('-delete');
});

// Modules ROUTES
Route::prefix('modules')->as('modules')->group(function () {
    Route::get('/', [ModulesController::class, 'index'])->name('');
    // Route::get('/create', [ModulesController::class, 'create'])->name('-add');
    Route::post('/store', [ModulesController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [ModulesController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [ModulesController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [ModulesController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [ModulesController::class, 'destroy'])->name('-delete');
});

// Topics ROUTES
Route::prefix('topics')->as('topics')->group(function () {
    Route::get('/', [TopicsController::class, 'index'])->name('');
    Route::get('/create', [TopicsController::class, 'create'])->name('-add');
    Route::post('/store', [TopicsController::class, 'store'])->name('-store');
    // Route::get('/view/{id}', [TopicsController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [TopicsController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [TopicsController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [TopicsController::class, 'destroy'])->name('-delete');
    //Route for AJAX
    Route::get('/moduleclass/{id}', [TopicsController::class, 'getModuleClass']);
});

// Posts ROUTES
Route::prefix('posts')->as('posts')->group(function () {
    Route::get('/', [PostsController::class, 'index'])->name('');
    Route::get('/create', [PostsController::class, 'create'])->name('-add');
    Route::post('/store', [PostsController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [PostsController::class, 'show'])->name('-view');
    Route::get('/edit/{id}', [PostsController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [PostsController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [PostsController::class, 'destroy'])->name('-delete');
    
    //Route for AJAX
    Route::get('/class2module/{id}', [PostsController::class, 'getClass2Module']);
    Route::get('/module2topic/{id}', [PostsController::class, 'getModule2Topic']);
});

// Comments ROUTES
Route::prefix('comments')->as('comments')->group(function () {
    Route::get('/', [CommentsController::class, 'index'])->name('');
    Route::get('/postcomments/{id}', [CommentsController::class, 'postComments'])->name('-postcomments');
    // Route::get('/create', [CommentsController::class, 'create'])->name('-add');
    Route::post('/storeparent', [CommentsController::class, 'storeParent'])->name('-storeparent');
    Route::post('/storechild', [CommentsController::class, 'storeChild'])->name('-storechild');
    Route::get('/disable/{id}/{currentstatus}', [CommentsController::class, 'disableComments'])->name('-disable');
    // Route::get('/view/{id}', [CommentsController::class, 'show'])->name('-view');
    // Route::get('/edit/{id}', [CommentsController::class, 'edit'])->name('-edit'); 
    // Route::patch('/update/{id}', [CommentsController::class, 'update'])->name('-update');
    Route::get('/delete/{id}/{userid}', [CommentsController::class, 'destroy'])->name('-delete');
});

// Resources ROUTES
Route::prefix('resources')->as('resources')->group(function () {
    Route::get('/', [ResourcesController::class, 'index'])->name('');
    Route::get('/create', [ResourcesController::class, 'create'])->name('-add');
    Route::post('/store', [ResourcesController::class, 'store'])->name('-store');
    Route::get('/view/{id}', [ResourcesController::class, 'show'])->name('-view');
    Route::get('/view/{id}/{type}', [ResourcesController::class, 'showWord'])->name('-viewword');
    // Route::get('/edit/{id}', [ResourcesController::class, 'edit'])->name('-edit');
    // Route::patch('/update/{id}', [ResourcesController::class, 'update'])->name('-update');
    Route::get('/delete/{class}/{type}/{id}', [ResourcesController::class, 'destroy'])->name('-delete');
    
    //Route for AJAX
    // Route::get('/class2module/{id}', [ResourcesController::class, 'getClass2Module']);
    // Route::get('/module2topic/{id}', [ResourcesController::class, 'getModule2Topic']);
});

// Quizes ROUTES
Route::prefix('quizzes')->as('quizzes')->group(function () {
    Route::get('/', [QuizController::class, 'index'])->name('');
    Route::get('/create', [QuizController::class, 'create'])->name('-add');
    Route::post('/store', [QuizController::class, 'store'])->name('-store');
    Route::get('/view/{quizId}/{classId}', [QuizController::class, 'show'])->name('-view');
    Route::get('/viewall/{quizId}', [QuizController::class, 'showAll'])->name('-viewall');
    
    Route::get('/viewscq/{quizId}/{classId}', [QuizController::class, 'showScq'])->name('-viewscq');
    Route::post('/storescq', [QuizController::class, 'storeScq'])->name('-storescq');
    Route::get('/scqedit/{questId}/{quizId}/{classId}', [QuizController::class, 'showSingleScqQuest'])->name('-scqedit');
    Route::patch('/scqupdate/{id}', [QuizController::class, 'updateSingleScqQuest'])->name('-scqupdate');
    Route::get('/scqdelete/{questId}/{classId}/{quizId}', [QuizController::class, 'deleteSingleScqQuest'])->name('-scqdelete');

    Route::get('/viewbq/{quizId}/{classId}', [QuizController::class, 'showBq'])->name('-viewbq');
    Route::post('/storebq', [QuizController::class, 'storeBq'])->name('-storebq');
    Route::get('/bqedit/{questId}/{quizId}/{classId}', [QuizController::class, 'showSingleBqQuest'])->name('-bqedit');
    Route::patch('/bqupdate/{id}', [QuizController::class, 'updateSingleBqQuest'])->name('-bqupdate');
    Route::get('/bqdelete/{questId}/{classId}/{quizId}', [QuizController::class, 'deleteSingleBqQuest'])->name('-bqdelete');
   
    Route::get('/viewtheory/{quizId}/{classId}', [QuizController::class, 'showTheory'])->name('-viewtheory');
    Route::post('/storetheory', [QuizController::class, 'storeTheory'])->name('-storetheory');
    Route::get('/theoryedit/{questId}/{quizId}/{classId}', [QuizController::class, 'showSingleTheoryQuest'])->name('-theoryedit');
    Route::patch('/theoryupdate/{id}', [QuizController::class, 'updateSingleTheoryQuest'])->name('-theoryupdate');
    Route::get('/theorydelete/{questId}/{classId}/{quizId}', [QuizController::class, 'deleteSingleTheoryQuest'])->name('-theorydelete');


    // Route::get('/view/{id}/{type}', [QuizController::class, 'showWord'])->name('-viewword');
    // Route::get('/edit/{id}', [QuizController::class, 'edit'])->name('-edit');
    Route::patch('/update/{id}', [QuizController::class, 'update'])->name('-update');
    Route::get('/delete/{id}', [QuizController::class, 'destroy'])->name('-delete');
    
    //Route for AJAX
    // Route::get('/class2module/{id}', [QuizController::class, 'getClass2Module']);
    // Route::get('/module2topic/{id}', [QuizController::class, 'getModule2Topic']);
});