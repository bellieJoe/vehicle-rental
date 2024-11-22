<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleCategoryController;
use App\Http\Controllers\VehicleController;
use App\Models\VehicleCategory;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use Stripe\Checkout\Session;
use Stripe\Stripe;

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
Route::view('/profile', 'main.profile')->name('profile')->middleware(['auth', 'verified']);
Route::view('/settings', 'main.settings')->name('settings')->middleware(['auth', 'verified']);
Route::put('/update-password', [UserController::class , 'updatePassword'])->name('updatePassword')->middleware(['auth', 'verified']);
Route::put('/update-profile', [UserController::class , 'updateProfile'])->name('updateProfile')->middleware(['auth', 'verified']);
Route::get("/galleries", [GalleryController::class, 'index'])->name('galleries');

Route::prefix('/email')->group(function () {
    Route::get('/verify', [UserController::class, 'verificationNotice'])
    ->name('verification.notice')->middleware('auth');

    Route::get('/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/verification-notification', [UserController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});


include 'password_reset.php';

Route::prefix('auth')->group(function () {
    Route::view('/signin', 'auth.signin')->name('auth.signin')->middleware('guest'); 
    Route::post('/register-client', [UserController::class, 'registerClient'])->name('auth.register-client')->middleware('guest'); 
    Route::post('/logout', [UserController::class, 'logout'])->name('auth.logout'); 
    Route::post('/try', [UserController::class, 'try'])->name('auth.try');
    Route::view('/signup', 'auth.signup')->name('auth.signup'); 
    Route::view('account-banned', 'auth.account-banned')->name('auth.account-banned')->middleware(['auth', 'verified']);
    
});

// ADMIN ROUTES
Route::prefix('admin')
->middleware(['auth', 'role:admin', 'verified', 'is_banned'])
->group(function () {
    Route::get('', [UserController::class, 'orgs'])->name('admin.index');
    Route::get('clients', [UserController::class, 'clients'])->name('admin.clients');
    Route::post('ban-account', [UserController::class, 'banAccount'])->name('admin.ban-account');
    Route::post('unban-account', [UserController::class, 'unbanAccount'])->name('admin.unban-account');

    Route::get('orgs', [UserController::class, 'orgs'])->name('admin.orgs');
    Route::post('orgs', [UserController::class, 'registerOrg'])->name('admin.register-org');

    Route::prefix('inquiries')->group(function () {
        Route::get('', [InquiryController::class, 'index'])->name('admin.inquiries.index');
        Route::post('reply', [InquiryController::class, 'reply'])->name('admin.inquiries.reply');
    });

});

// ORG ROUTES
Route::prefix('org')
->middleware(['auth', 'role:org', 'verified', 'is_banned'])
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
        Route::get('edit/{package_id}', [PackageController::class, 'edit'])->name('org.packages.edit');
        Route::post('update/{package_id}', [PackageController::class, 'update'])->name('org.packages.update');
    });

    Route::prefix("bookings")->group(function () {
        Route::get('', [OrgController::class, 'bookings'])->name('org.bookings.index');    
        Route::get('edit/{booking_id}', [OrgController::class, 'editBooking'])->name('org.bookings.edit');    
        Route::put('update/{booking_id}', [OrgController::class, 'updateBooking'])->name('org.bookings.update');
        Route::prefix("payments")->group(function () {
            Route::get('{booking_id}', [OrgController::class, 'paymentsView'])->name('org.bookings.payments');
            Route::post('approve/{payment_id}', [OrgController::class, 'approvePayment'])->name('org.bookings.payments.approve');
            Route::post('invalid/{payment_id}', [OrgController::class, 'invalidPayment'])->name('org.bookings.payments.invalid');
            Route::post('approve-cash/{payment_id}', [OrgController::class, 'approveCashPayment'])->name('org.bookings.payments.approve-cash');
        });
    });

    Route::prefix("galleries")->group(function () { 
        Route::get('', [OrgController::class, 'galleries'])->name('org.galleries.index');
        Route::post('', [OrgController::class, 'galleryStore'])->name('org.galleries.store');
        Route::get('create', [OrgController::class, 'galleryCreate'])->name('org.galleries.create');
        Route::get('edit/{gallery_id}', [OrgController::class, 'galleryEdit'])->name('org.galleries.edit');
        Route::put('update/{gallery_id}', [OrgController::class, 'galleryUpdate'])->name('org.galleries.update');
    });

});

// CLIENT ROUTES
Route::prefix('client')
->middleware(['auth', 'role:client', 'verified',  'is_banned'])
->group( function () {
    Route::redirect("", "/client/vehicles");
    Route::prefix("vehicles")->group(function () {
        Route::get('', [ClientController::class, 'vehicles'])->name('client.vehicles');
        Route::get('rent/{vehicle_id}', [ClientController::class, 'rentView'])->name('client.vehicles.rentView');   
        Route::post('rent', [ClientController::class, 'rentStore'])->name('client.vehicles.rentStore'); 
    });
    Route::prefix("bookings")->group(function () {
        Route::get('', [ClientController::class, 'bookings'])->name('client.bookings');
        Route::get('cancel/{booking_id}', [ClientController::class, 'cancelBookingView'])->name('client.bookings.cancelView');
        Route::put('cancel/{booking_id}', [ClientController::class, 'cancelBooking'])->name('client.bookings.cancel');
        Route::prefix("payments")->group(function () {
            Route::get('{booking_id}', [ClientController::class, 'paymentsView'])->name('client.bookings.payments');
            Route::post('pay-gcash', [ClientController::class, 'payGcash'])->name('client.bookings.payments.gcash');
            Route::post('pay-debit', [ClientController::class, 'payDebit'])->name('client.bookings.payments.debit');
            Route::get('pay-debit-success/{token}', [ClientController::class, 'debitSuccess'])->name('client.bookings.payments.debit-success');
            Route::get('pay-debit-failed/{token}', [ClientController::class, 'debitFailed'])->name('client.bookings.payments.debit-failed');
        });
    });
});

// API
Route::prefix('api')->group(function () {
    Route::prefix("vehicles")->group(function () {
        Route::get('query-by-user/{user_id}', [VehicleController::class, 'apiQuery'])->name('api.vehicles.apiQueryByUser');
        Route::get('get-schedule/{vehicle_id}', [VehicleController::class, 'getVehicleBookings'])->name('api.vehicles.booking-schedule');
    });

});


Route::get('/mailable', function () {
 
    // return new OrgRegistered();
});


// Inquiry
Route::prefix('inquiry')->group(function () {
    Route::post('', [InquiryController::class, 'store'])->name('inquiry.store');
});
