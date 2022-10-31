<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\ProjectController;

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

// Route::get('/', function () {
//     return view('admin.login');
// });
Route::get('/',[HomeController::class,'landing'])->name('home');
Route::get('/registration',[HomeController::class,'test'])->name('registration');
Route::post('/saveUser',[AuthController::class,'saveUser'])->name('registration');
Route::get('/demo', function () {
    return view('mails.welcome-mail');
});
Route::get('/blank', function () {
    return view('admin.blank-page');
});

Route::get('/users',[AuthController::class,'users'])->name('viewUsers');
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', [App\Http\Controllers\TestController::class, 'index']);
Route::post('getPlead',[AuthController::class,'getPlead'])->name('getPlead');
Route::get('levelthree',[HomeController::class,'level3'])->name('l3dash');
Route::get('changeStatus/{id}',[HomeController::class,'changeStatus'])->name('changeStatus');
Route::post('updateStatus',[HomeController::class,'updateStatus'])->name('updateStatus');
Route::post('updateStatuss',[HomeController::class,'updateStatuss'])->name('updateStatuss');
Route::get('/login',[App\Http\Controllers\UsersloginController::class,'Loginpage'])->middleware('alreadyloggedin','AlreadyLoggedInlevel1','AlreadyLoggedInlevel2','AlreadyLoggedInlevel3');

// faisal routes
    //  for admin  
    Route::post('login/login',[App\Http\Controllers\UsersloginController::class,'CheckUsers']);
    Route::get('/admin/dashboard',[HomeController::class,'registration'])->name('adminHome')->middleware('isAdmin');
    Route::get('/users',[AuthController::class,'users'])->name('viewUsers');
    Route::get('/admin/dashboard/users',[App\Http\Controllers\AdminController::class,'users'])->middleware('isAdmin')->name('viewUsers');
    Route::get('/admin/logout',[App\Http\Controllers\UsersloginController::class,'Admin_logout']);

    // for level1
    Route::group(['prefix' => '/level1'],function(){
        
    Route::get('dashboard',[App\Http\Controllers\Users\Level1Controller::class,'index'])->middleware('Islevel1')->name('l1dash');
    Route::get('logout',[App\Http\Controllers\UsersloginController::class,'level1_logout']);

    });
     
    // for level2

    Route::group(['prefix' => '/level2'],function(){
        Route::get('dashboard',[App\Http\Controllers\Users\Level2Controller::class,'index'])->name('level2dash')->middleware('Islevel2');
        Route::get('logout',[App\Http\Controllers\UsersloginController::class,'level2_logout']);
        Route::get('level3task',[App\Http\Controllers\Users\Level2Controller::class,'level3Task'])->name('level3task');

    });

    // for level3 

    Route::group(['prefix' =>'/level3'],function(){
        Route::get('dashboard',[App\Http\Controllers\Users\Level3Controller::class,'index'])->name('level3dash')->middleware('Islevel3');
        Route::get('logout',[App\Http\Controllers\UsersloginController::class,'level3_logout']);

    });


    // adarsh route
    Route::prefix('user')->group(function () {
        Route::get('/list', [UserController::class, 'index'])->name('user.list');
        Route::get('/list/fetch', [UserController::class, 'getData'])->name('user.list.fetch');
        Route::get('/view/edit/{id}', [UserController::class, 'viewEdit'])->name('user.view.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/update/status/{id}', [UserController::class, 'changeStatus'])->name('user.update.status');
    });

    Route::prefix('project')->group(function () {
        Route::get('/list', [ProjectController::class, 'index'])->name('project.list');
        Route::get('/list/fetch', [ProjectController::class, 'getData'])->name('project.list.fetch');
        Route::post('/add', [ProjectController::class, 'add'])->name('project.add');
        Route::get('/view/edit/{id}', [ProjectController::class, 'viewEdit'])->name('project.view.edit');
        Route::post('/update/{id}', [ProjectController::class, 'update'])->name('project.update');
        Route::post('/update/status/{id}', [ProjectController::class, 'changeStatus'])->name('project.update.status');
    });


    //cookie routes
Route::post('/create/cookie', [CookieController::class, 'create'])->name('set.cookie');
Route::post('/fetch/cookie', [CookieController::class, 'fetch'])->name('get.cookie');
Route::post('/remove/cookie', [CookieController::class, 'remove'])->name('remove.cookie');


// Sachins routes
Route::post('create-task', [App\Http\Controllers\TaskController::class, 'createTask']);
Route::post('getUsers', [App\Http\Controllers\TaskController::class, 'getUsers']);
Route::post('getCompany', [App\Http\Controllers\TaskController::class, 'getCompany']);
Auth::routes();
Route::prefix('l1')->group(function () {
    Route::view('/', 'user.level1.index');
    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index_l1']);
    
});

Route::get('logout',[AuthController::class,'logout'])->name('logout');