<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome')->name('home');
Route::view('/home', 'welcome');
Route::get('/app', [UserController::class, 'app'])
->name('app')
->middleware('auth');

Route::prefix('auth')->group(function () {
    Route::view('/signin', 'auth.signin')->name('auth.signin')->middleware('guest'); 
    Route::post('/logout', [UserController::class, 'logout'])->name('auth.logout'); 
    Route::post('/try', [UserController::class, 'try'])->name('auth.try');
    Route::view('/signup', 'auth.signup')->name('auth.signup'); 
});

Route::prefix('admin')->group(function () {
    Route::view('', 'main.admin.index')->name('admin.index')->middleware('auth');
    Route::get('clients', [UserController::class, 'clients'])->name('admin.clients')->middleware('auth');
    Route::get('orgs', [UserController::class, 'orgs'])->name('admin.orgs')->middleware('auth');
});

Route::prefix('org')->group(function () {
    
});

Route::prefix('client')->group(function () {
    
});

Route::prefix('api')->group(function () {
    
});


