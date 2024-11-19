<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
use App\Mail\OrgRegistered;
use App\Models\Organisation;
use App\Models\User;
use App\Models\Vehicle;
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
Route::get('/app', [UserController::class, 'app'])->name('app')->middleware('auth');

Route::prefix('/email')->group(function () {
    Route::get('/verify', [UserController::class, 'verificationNotice'])
    ->name('verification.notice')->middleware('auth');

    Route::get('/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/verification-notification', [UserController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

Route::prefix('auth')->group(function () {
    Route::view('/signin', 'auth.signin')->name('auth.signin')->middleware('guest'); 
    Route::post('/register-client', [UserController::class, 'registerClient'])->name('auth.register-client')->middleware('guest'); 
    Route::post('/logout', [UserController::class, 'logout'])->name('auth.logout'); 
    Route::post('/try', [UserController::class, 'try'])->name('auth.try');
    Route::view('/signup', 'auth.signup')->name('auth.signup'); 
});


// ADMIN ROUTES
Route::prefix('admin')
->middleware(['auth', 'role:admin', 'verified'])
->group(function () {
    Route::view('', 'main.admin.index')->name('admin.index');
    Route::get('clients', [UserController::class, 'clients'])->name('admin.clients');

    Route::get('orgs', [UserController::class, 'orgs'])->name('admin.orgs');
    Route::post('orgs', [UserController::class, 'registerOrg'])->name('admin.register-org');
});

// ORG ROUTES
Route::prefix('org')
->middleware(['auth', 'role:org', 'verified'])
->group(function () {
    Route::view('', 'main.org.index')->name('org.index');
    Route::prefix('vehicles')->group(function () {
        Route::get('', [VehicleController::class, 'index'])->name('org.vehicles.index'); 
        Route::post('', [VehicleController::class, 'create'])->name('org.vehicles.create'); 
        Route::put('', [VehicleController::class, 'update'])->name('org.vehicles.update'); 
        Route::delete('', [VehicleController::class, 'delete'])->name('org.vehicles.delete'); 
        Route::post('set-availability/{vehicle_id}', [VehicleController::class, 'setAvailability'])->name('org.vehicles.set-availability'); 

        Route::prefix('categories')->group(function () {
            Route::get('', [VehicleCategoryController::class, 'index'])->name('org.vehicles.category.index');
            Route::post('', [VehicleCategoryController::class, 'create'])->name('org.vehicles.category.create');
            Route::delete('', [VehicleCategoryController::class, 'delete'])->name('org.vehicles.category.delete');
            Route::put('', [VehicleCategoryController::class, 'update'])->name('org.vehicles.category.update');
        });
    });

    Route::prefix('packages')->group(function () {
        Route::get('', [PackageController::class, 'index'])->name('org.packages.index');
        Route::get('create', [PackageController::class, 'create'])->name('org.packages.create');
        Route::post('', [PackageController::class, 'store'])->name('org.packages.store');
    });

    Route::prefix("bookings")->group(function () {
        Route::get('', [OrgController::class, 'bookings'])->name('org.bookings.index');    
        Route::get('edit/{booking_id}', [OrgController::class, 'editBooking'])->name('org.bookings.edit');    
        Route::put('update/{booking_id}', [OrgController::class, 'updateBooking'])->name('org.bookings.update');    
    });

});

// CLIENT ROUTES
Route::prefix('client')
->middleware(['auth', 'role:client', 'verified'])
->group( function () {
    Route::redirect("", "/client/vehicles");
    Route::prefix("vehicles")->group(function () {
        Route::get('', [ClientController::class, 'vehicles'])->name('client.vehicles');
        Route::get('rent/{vehicle_id}', [ClientController::class, 'rentView'])->name('client.vehicles.rentView');   
        Route::post('rent', [ClientController::class, 'rentStore'])->name('client.vehicles.rentStore'); 
    });
    Route::prefix("bookings")->group(function () {
        Route::get('', [ClientController::class, 'bookings'])->name('client.bookings');
    });
});

// API
Route::prefix('api')->group(function () {
    Route::prefix("vehicles")->group(function () {
        Route::get('query-by-user/{user_id}', [VehicleController::class, 'apiQuery'])->name('api.vehicles.apiQueryByUser');
    });
});


Route::get('/mailable', function () {
 
    // return new OrgRegistered();
});

