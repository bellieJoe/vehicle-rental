<?php

use App\Http\Controllers\AdditionalRateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\OrgController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReportController;
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
Route::view("/toc-bookings", "toc.bookings-toc")->name("toc.bookings");
Route::view("/toc", "toc.registration-toc")->name("toc.registration");


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

    Route::prefix("galleries")->group(function () { 
        Route::get('', [GalleryController::class, 'galleries'])->name('admin.galleries.index');
        Route::post('', [GalleryController::class, 'galleryStore'])->name('admin.galleries.store');
        Route::get('create', [GalleryController::class, 'galleryCreate'])->name('admin.galleries.create');
        Route::get('edit/{gallery_id}', [GalleryController::class, 'galleryEdit'])->name('admin.galleries.edit');
        Route::put('update/{gallery_id}', [GalleryController::class, 'galleryUpdate'])->name('admin.galleries.update');
        Route::delete('update/{gallery_id}', [GalleryController::class, 'galleryDelete'])->name('admin.galleries.destroy');
    });

});


// ORG ROUTES
Route::prefix('org')
->middleware(['auth', 'role:org', 'verified', 'is_banned'])
->group(function () {
    Route::get('', [OrgController::class, 'index'])->name('org.index');
    Route::prefix('vehicles')->group(function () {
        Route::get('', [VehicleController::class, 'index'])->name('org.vehicles.index'); 
        Route::get('create', [VehicleController::class, 'createView'])->name('org.vehicles.createView'); 
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
        
        Route::prefix("additional-rates")->group(function () {
            Route::get('', [AdditionalRateController::class, 'index'])->name('org.additional-rates.index');
            Route::get('create', [AdditionalRateController::class, 'create'])->name('org.additional-rates.create');
            Route::post('create', [AdditionalRateController::class, 'store'])->name('org.additional-rates.store');
            Route::get('edit/{additional_rate_id}', [AdditionalRateController::class, 'edit'])->name('org.additional-rates.edit');
            Route::post('edit/{additional_rate_id}', [AdditionalRateController::class, 'update'])->name('org.additional-rates.update');
            Route::delete('delete/{additional_rate_id}', [AdditionalRateController::class, 'delete'])->name('org.additional-rates.delete');
        });
    });

    Route::prefix("refunds")->group(function () {
        Route::get('', [OrgController::class, 'viewRefunds'])->name('org.refunds.index');
        Route::put('process', [OrgController::class, 'processRefund'])->name('org.refunds.process');
    });

    Route::prefix('packages')->group(function () {
        Route::get('', [PackageController::class, 'index'])->name('org.packages.index');
        Route::get('create', [PackageController::class, 'create'])->name('org.packages.create');
        Route::post('', [PackageController::class, 'store'])->name('org.packages.store');
        Route::get('edit/{package_id}', [PackageController::class, 'edit'])->name('org.packages.edit');
        Route::post('update/{package_id}', [PackageController::class, 'update'])->name('org.packages.update');
        Route::post('set-availability/{package_id}', [PackageController::class, 'setAvailability'])->name('org.package.set-availability'); 
        Route::delete('delete', [PackageController::class, 'destroy'])->name('org.package.delete'); 
    });

    Route::prefix("bookings")->group(function () {
        Route::get('', [OrgController::class, 'bookings'])->name('org.bookings.index');    
        Route::get('edit/{booking_id}', [OrgController::class, 'editBooking'])->name('org.bookings.edit');    
        Route::put('update/{booking_id}', [OrgController::class, 'updateBooking'])->name('org.bookings.update');
        Route::post('complete/{booking_id}', [OrgController::class, 'completeBooking'])->name('org.bookings.complete');
        Route::prefix("payments")->group(function () {
            Route::get('{booking_id}', [OrgController::class, 'paymentsView'])->name('org.bookings.payments');
            Route::post('approve/{payment_id}', [OrgController::class, 'approvePayment'])->name('org.bookings.payments.approve');
            Route::post('invalid/{payment_id}', [OrgController::class, 'invalidPayment'])->name('org.bookings.payments.invalid');
            Route::post('approve-cash/{payment_id}', [OrgController::class, 'approveCashPayment'])->name('org.bookings.payments.approve-cash');
            Route::post('reset-attempts/{payment_id}', [OrgController::class, 'resetAttempts'])->name('org.bookings.payments.reset-attempts');
        });
    });

    Route::prefix("routes")->group(function () {
        Route::get('', [OrgController::class, 'routes'])->name('org.routes.index');
        Route::get('create', [OrgController::class, 'routeCreate'])->name('org.routes.create');
        Route::post('', [OrgController::class, 'routeStore'])->name('org.routes.store');
        Route::get('edit/{route_id}', [OrgController::class, 'routeEdit'])->name('org.routes.edit');
        Route::put('update/{route_id}', [OrgController::class, 'routeUpdate'])->name('org.routes.update');
        Route::delete('delete/{route_id}', [OrgController::class, 'routeDelete'])->name('org.routes.delete');

        Route::prefix("additional-rates")->group(function () {
            Route::get('index/{route_id}', [OrgController::class, 'additionalRates'])->name('org.routes.additional-rates.index');
            Route::get('create/{route_id}', [OrgController::class, 'additionalRateCreate'])->name('org.routes.additional-rates.create');
            Route::post('store/{route_id}', [OrgController::class, 'additionalRateStore'])->name('org.routes.additional-rates.store');
            Route::get('edit/{additional_rate_id}', [OrgController::class, 'additionalRateEdit'])->name('org.routes.additional-rates.edit');
            Route::put('update/{additional_rate_id}', [OrgController::class, 'additionalRateUpdate'])->name('org.routes.additional-rates.update');
            Route::delete('delete/{additional_rate_id}', [OrgController::class, 'additionalRateDelete'])->name('org.routes.additional-rates.delete');
        });

    });
    
    Route::prefix("d2d-vehicles")->group(function () {
        Route::get('', [OrgController::class, 'd2dVehicles'])->name('org.d2d-vehicles.index'); 
        Route::get('create', [OrgController::class, 'd2dVehicleCreate'])->name('org.d2d-vehicles.create');  
        Route::post('', [OrgController::class, 'd2dVehicleStore'])->name('org.d2d-vehicles.store');
        Route::get('edit/{d2d_vehicle_id}', [OrgController::class, 'd2dVehicleEdit'])->name('org.d2d-vehicles.edit');
        Route::put('update/{d2d_vehicle_id}', [OrgController::class, 'd2dVehicleUpdate'])->name('org.d2d-vehicles.update');
        Route::delete('delete/{d2d_vehicle_id}', [OrgController::class, 'd2dVehicleDelete'])->name('org.d2d-vehicles.delete');

        Route::prefix("{d2d_vehicle_id}/d2d-schedules")->group(function () {
            Route::get('', [OrgController::class, 'd2dSchedules'])->name('org.d2d-schedules.index');
            Route::get('create', [OrgController::class, 'd2dScheduleCreate'])->name('org.d2d-schedules.create');
            Route::post('', [OrgController::class, 'd2dScheduleStore'])->name('org.d2d-schedules.store');
            Route::delete('delete/{d2d_schedule_id}', [OrgController::class, 'd2dScheduleDelete'])->name('org.d2d-schedules.delete');
        });
    });

    Route::prefix("reports")->group(function () {
        Route::get('collections', [ReportController::class, 'collections'])->name('org.reports.collections');
        Route::get('refunds', [ReportController::class, 'refunds'])->name('org.reports.refunds');
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
    Route::prefix("packages")->group(function () {
        Route::get('', [ClientController::class, 'packages'])->name('client.packages');
        Route::get('book/{package_id}', [ClientController::class, 'bookPackageView'])->name('client.packages.bookView');
        Route::post('book', [ClientController::class, 'bookStore'])->name('client.vehicles.bookStore'); 
    });

    Route::prefix("refund")->group(function () {
        Route::get("booking/{booking_id}", [ClientController::class, 'refundView'])->name('client.refund.view');
        Route::post("booking/{booking_id}", [ClientController::class, 'storeRefund'])->name('client.refund.store');
    });

    Route::prefix("feedbacks")->group(function () {
        Route::post('', [ClientController::class, 'storeFeedback'])->name('client.feedbacks.store'); 
    });

    Route::prefix("door-to-door")->group(function () {
        Route::get('', [ClientController::class, 'viewD2d'])->name('client.d2d.index');
        Route::get('create/{d2d_vehicle_id}', [ClientController::class, 'bookD2d'])->name('client.d2d.create');
        Route::post('book/{d2d_vehicle_id}', [ClientController::class, 'storeD2d'])->name('client.d2d.store');
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
            Route::get('receipt/{payment_id}', [ClientController::class, 'downloadReceipt'])->name('client.bookings.payments.receipt');
        });
    });
});

// API
Route::prefix('api')->group(function () {
    Route::prefix("vehicles")->group(function () {
        Route::get('query-by-user/{user_id}', [VehicleController::class, 'apiQuery'])->name('api.vehicles.apiQueryByUser');
        Route::get('get-schedule/{vehicle_id}', [VehicleController::class, 'getVehicleBookings'])->name('api.vehicles.booking-schedule');
    });

    Route::prefix("package")->group(function () {
        Route::get('get-schedule/{package_id}', [PackageController::class, 'getPackageBookings'])->name('api.packages.booking-schedule');
    });

    Route::get('owner-bookings/{user_id}', [OrgController::class, 'getOwnerBookings'])->name('api.owner-bookings');

    Route::get('d2d-schedules/{d2d_vehicle_id}', [OrgController::class, 'getD2dSchedules'])->name('api.d2d-schedules');
});

// feedbacks
Route::prefix('feedbacks')->group(function () {
    Route::get('{type}/{id}', [FeedbackController::class, 'index'])->name('feedbacks.index');
});


Route::get('/mailable', function () {
 
    // return new OrgRegistered();
});


// Inquiry
Route::prefix('inquiry')->group(function () {
    Route::post('', [InquiryController::class, 'store'])->name('inquiry.store');
});
