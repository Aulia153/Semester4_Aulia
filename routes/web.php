<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

//Route with name
Route::get('/', function () {
    return view('welcome');
});

//Basic route
Route::get('/foo', function () {
    return 'Hello World';
});

//Route with parameter
Route::get('/foo/{id}', function ($id) {
    return 'User ' .$id;
});

//Route parameter checking
Route::get('/hallo/{id?}', function ($ya = 'parameter kosong') {
    return $ya;
});

//Route call view
Route::get('/user', [UserController::class, 'viewUser'])->name('user');

//Route method post
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

//Route redirect
Route::redirect('/welcome', '/');

//Route redirect with status
Route::redirect('/welcome301', '/', 301); //moved permanent
Route::redirect('/welcome302', '/', 302); //found (temporary rdirect)
Route::redirect('/welcome303', '/', 303); //see other
Route::redirect('/welcome307', '/', 307); //Temporary rdirect
Route::redirect('/welcome308', '/', 308); //permanent redirect

//Route regular expression constrains
Route::get('/hai/{name}', function ($name) {
    return "hallo, $name!";
})->where('name', '[A-Za-z]+');

//Route Global constraint take it from providers
Route::get('/nameglobal/{nameGlobal}', function ($nameGlobal) {
    return "Hallo, $nameGlobal!";
});
Route::get('/idGlobal/{idGlobal}', function ($idGlobal) {
    return "User ID: $idGlobal";
});

//Route encoded Forward Slashes
Route::get('/search/{search}', function ($search) {
    return $search;
})->where('search', '.*');

//Generate URL ke Roure bernama
Route::get('/profile', [UserController::class, 'showProfile'])->name('profileya');
Route::get('/generate-url', [UserController::class, 'generateProfileUrl']);
Route::get('/redirect-profile', [UserController::class, 'redirectToProfile']);

//Cek route
Route::get('/profilCek', [UserController::class, 'showProfile'])
->name('profile')
->middleware('check.route');//diambil dari app/dulu kernel

//Route group with middleware
Route::middleware([check.user])->group(function () {
    Route::get('/dashboardLogin', [UserController::class, 'dashboardL'])->name('dashboard');
    Route::get('/profileLogin', [UserController::class, 'profileL'])->name('profile');
    Route::get('/settingsLogin', [UserController::class, 'settingsL'])->name('settings');
});

//Route group with namespace
Route::namespace('App\Http\Controllers\User')->group(function () {
    Route::get('/user/info', 'UserController@info')->name('user.info');
    Route::get('/user/data', 'DataController@data')->name('user.data');
});

//Subdomain Routing
Route::domain('{account}.example.com')->group(function () {
    Route::get('/', function ( $account) {
        return "Ini halaman untuk akun: " . $account;
    });
});

//Route prefix
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return "Ini halaman dashboard admin.";
    });
    Route::get('/db', function () {
        return "Ini halaman db admin";
    });
});

//Route name repvix
Route::name('prefix.')->prefix('cobalagi')->group(function () {
    Route::get('/dashboard', function () {
        return "Ini halaman dashboard previx name.";
    })->name('pv.dashboard');

    Route::get('/user', function () {
        return "Ini halaman daftar pengguna previx name.";
    })->name('pv.user');
});

