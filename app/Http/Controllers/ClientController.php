<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Models\AdditionalRate;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingLog;
use App\Models\Feedback;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ClientController extends Controller
{
    public function vehicles(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date|required_with:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_with:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $vehiclesQuery = Vehicle::where('is_available', 1)
        ->with([
            'vehicleCategory',
            'user.organisation',
        ]);

        // Apply the date filter only if both dates are provided
        if ($startDate && $endDate) {
            $startDateTime = Carbon::parse($startDate);
            $endDateTime = Carbon::parse($endDate);

            $vehiclesQuery->whereDoesntHave('bookings', function ($query) use ($startDateTime, $endDateTime) {
                $query->where('status', 'Booked')
                    ->whereHas('bookingDetail', function ($detailsQuery) use ($startDateTime, $endDateTime) {
                        $detailsQuery->where(function ($query) use ($startDateTime, $endDateTime) {
                            $query->where('start_datetime', '<', $endDateTime)
                                ->whereRaw('DATE_ADD(start_datetime, INTERVAL number_of_days DAY) > ?', [$startDateTime]);
                        });
                    });
            });
        }

        $vehicles = $vehiclesQuery->paginate(10);

        return view('main.client.vehicles', [
            'vehicles' => $vehicles,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }


    public function rentView(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::find($vehicle_id);
        $additional_rates = $vehicle->user->additionalRates->where('vehicle_category_id', $vehicle->vehicle_category_id);
        
        return view('main.client.rent')
            ->with([
                'vehicle' => $vehicle,
                'additional_rates' => $additional_rates
            ]);
    }

    public function rentStore(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'booking_type' => 'required|in:Vehicle,Package',
            'contact_number' => 'required|regex:/^09\d{9}$/',
            'name' => 'required',
            'start_date' => 'required|date|after:'.now()->addDay(),
            'number_of_days' => 'required|integer|min:1',
            'rent_options' => 'required|in:With Driver,Without Driver',
            // 'payment_method' => 'required|in:Cash,Gcash,Debit',
            'additional_rate' => 'nullable|exists:additional_rates,id',
            'payment_option' => 'required|in:'.Payment::OPTION_FULL_PAYMENT.','.Payment::OPTION_INSTALLMENT,
            'pickup_location' => 'required',
        ]);

        // check if vehicle is available
        if(!$this->isVehicleAvailable($request->vehicle_id, $request->start_date, $request->number_of_days, Booking::STATUS_BOOKED)){
            return redirect()
            ->back()
            ->with('error', "Sorry, this vehicle is already booked from ".Carbon::parse($request->start_date)->format('M d, Y')." to ".Carbon::parse($request->start_date)->addDays($request->number_of_days)->format('M d, Y').". Please choose a different date or vehicle.")
            ->withInput();
        }

        // check if has double booking
        if(!$this->checkDoubleBooking($request->vehicle_id, $request->start_date, $request->number_of_days, Booking::STATUS_PENDING)){
            return redirect()
            ->back()
            ->withErrors(['error' => "It appears you already have a booking for these dates."])
            ->withInput();
        }

        return DB::transaction(function () use ($request) {

            // check for double booking
            $additional_rate = null;
            if($request->additional_rate){
                $additional_rate = AdditionalRate::find($request->additional_rate);
            }

            $vehicle = Vehicle::find($request->vehicle_id);
            $rate_per_day = $request->rent_options === 'With Driver' ? $vehicle->rate_with_driver : $vehicle->rate_without_driver;
            $computed_price = ($rate_per_day * $request->number_of_days) + ($additional_rate ? $additional_rate->rate : 0);

            $booking = Booking::create([
                'transaction_number' => time().auth()->user()->id,
                'booking_type' => $request->booking_type,
                'user_id' => auth()->user()->id,
                'contact_number' => $request->contact_number,
                'name' => $request->name,
                'vehicle_id' => $request->vehicle_id,
                'computed_price' => $computed_price,
                'status' => Booking::STATUS_PENDING,
                // 'payment_status' => Payment::STATUS_PENDING
            ]);

            BookingDetail::create([
                'booking_id' => $booking->id,
                'start_datetime' => $request->start_date,
                'number_of_days' => $request->number_of_days,
                'with_driver' => $request->rent_options === 'With Driver',
                'pickup_location' => $request->rent_options === 'With Driver' ? $request->pickup_location : null
            ]);

            BookingLog::create([
                'booking_id' => $booking->id,
                'log' => auth()->user()->name.' Created the booking',
            ]);

            $this->_createPayments($booking, $request);

            Mail::to($vehicle->user->email)->send(new BookingUpdate($booking, 'You have new vehicle booking.', $vehicle->user, route('org.bookings.index')));
            
            return redirect()->route('client.bookings');   
        });
    }

    public function bookings(Request $request)
    {
        $status = $request->query('status');
        $query = Booking::where('user_id', auth()->user()->id)
            ->with([
                'vehicle.user.organisation',
                'vehicle.vehicleCategory',
                'bookingDetail',
                'bookingLogs'
            ])
            ->withCount('refunds')
            ->orderBy('created_at', 'DESC');

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10);

        return view('main.client.bookings.bookings')
            ->with([
                'bookings'=> $bookings
            ]);
    }

    public function cancelBooking(Request $request, $booking_id)
    {    
        $request->validate([
            'reason' => 'required|max:5000'
        ]);
        return DB::transaction(function () use ($request, $booking_id) {
    
            $booking = Booking::with([
                'vehicle.user.organisation',
                'vehicle.vehicleCategory',
                'package.user.organisation',
                'package.user'
            ])->find($booking_id);
            

            if(!$booking){
                return redirect()->back()->withErrors(['others' => 'Booking not found']);
            }

            if(in_array($booking->status, [Booking::STATUS_CANCELLED, Booking::STATUS_REJECTED, Booking::STATUS_COMPLETED])){
                return redirect()->back()->withErrors(['others' => 'Invalid booking action.']);
            }

            $booking->update([
                'status' => Booking::STATUS_CANCELLED
            ]);
    
            BookingLog::create([
                'booking_id' => $booking->id,
                'log' => auth()->user()->name.' Cancelled the booking',
                'reason' => $request->reason
            ]);
    
            $to = $booking->booking_type == "Vehicle" ? $booking->vehicle?->user : $booking->package?->user;
            Mail::to($to->email)->send(new BookingUpdate(
                $booking, 
                "Booking from ".auth()->user()->name." has been cancelled", 
                auth()->user(),
                route('org.bookings.index'))
            );
    
            return redirect()->route('client.bookings')->with('success', 'Booking cancelled successfully');
        });
    }

    public function cancelBookingView(Request $request, $booking_id)
    {
        $booking = Booking::find($booking_id);
        return view('main.client.bookings.cancel')
            ->with([
                'booking' => $booking
            ]);
    }

    public function paymentsView(Request $request, $booking_id)
    {
        $booking = Booking::find($booking_id);

        return view('main.client.bookings.payments')
            ->with([
                'booking' => $booking
            ]);
    }

    public function payGcash(Request $request) {

        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'gcash_transaction_no' => 'required',
            'toc' => 'required|in:on',
        ]);

        $payment = Payment::find($request->payment_id);

        $payment->update([
            'gcash_transaction_no' => $request->gcash_transaction_no,
            'payment_status' => Payment::STATUS_GCASH_APPROVAL,
            'attempts' => $payment->attempts + 1,
            'payment_method' => Payment::METHOD_GCASH
        ]);

        $orgUser = $payment->booking->vehicle ? $payment->booking->vehicle->user : $payment->booking->package->user;

        Mail::to($orgUser->email)->send(new BookingUpdate(
            $payment->booking, 
            "Payment from ".auth()->user()->name." has been made via gcash", 
            $orgUser,
            back()->getTargetUrl())
        );

        return redirect()->back()->with('success', 'Gcash payment successfully added, please wait for the business owner to approve your payment.');
    }

    public function payDebit(Request $request, ) {
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'toc' => 'required|in:on',
        ]);

        $payment = Payment::find($request->payment_id);
        $org = null;
        
        if($payment->booking->booking_type == "Vehicle"){
            $org = $payment->booking->vehicle->user->organisation;
        }
        if($payment->booking->booking_type == "Package"){
            $org = $payment->booking->package->user->organisation;
        }
        if (is_null($org)) {
            return redirect()->back()->with("error", "Something went wrong while processing the payment.");
        }

        Stripe::setApiKey($org->stripe_secret_key);
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => "PHP",
                    'product_data' => [
                        'name' => "#".$payment->booking->transaction_number." Booking Payment",
                    ],
                    'unit_amount' => $payment->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('client.bookings.payments.debit-success', Crypt::encrypt($payment->id)),
            'cancel_url' => route("client.bookings.payments.debit-failed", Crypt::encrypt($payment->id)),
        ]);
        return redirect($session->url);
    }

    public function debitSuccess(Request $request, $token){
        $payment_id = Crypt::decrypt($token);
        $payment = Payment::find($payment_id);
        $payment->update([
            "payment_status" => Payment::STATUS_PAID,
            'attempts' => $payment->attempts + 1,
            'payment_method' => Payment::METHOD_DEBIT,
            'date_paid' => now(),
        ]);
        $orgUser = $payment->booking->vehicle ? $payment->booking->vehicle->user : $payment->booking->package->user;
        Mail::to($orgUser->email)->send(new BookingUpdate(
            $payment->booking, 
            "Payment from ".auth()->user()->name." has been made via gcash", 
            $orgUser,
            back()->getTargetUrl())
        );

        $booking = $payment->booking;
        if($payment->is_downpayment || $booking->payments_count == 0){
            $booking->update([
                'status' => Booking::STATUS_BOOKED,
            ]); 
        }

        Mail::to(auth()->user()->email)->send(new BookingUpdate($payment->booking, "Your booking has been secured.", auth()->user(), route('client.bookings')));

        return redirect()->route('client.bookings.payments', $payment->booking->id)->with('success', 'Debit payment successfully added.');
    }

    public function debitFailed(Request $request, $token){
        $payment_id = Crypt::decrypt($token);
        $payment = Payment::find($payment_id);
        $payment->update([
            'attempts' => $payment->attempts + 1,
            'payment_method' => Payment::METHOD_DEBIT,
        ]);
        return redirect()->route('client.bookings.payments', $payment->booking->id)->with('success', 'Debit payment failed.');
    }

    public function packages(Request $request){
        $request->validate([
            'start_date' => 'nullable|date|required_with:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date|required_with:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $packagesQuery = Package::where('is_available', 1)
        ->with([
            'user.organisation'
        ]);

        // Apply the date filter only if both dates are provided
        if ($startDate && $endDate) {
            $startDateTime = Carbon::parse($startDate);
            $endDateTime = Carbon::parse($endDate);

            $packagesQuery->whereDoesntHave('bookings', function ($query) use ($startDateTime, $endDateTime) {
                $query->where('status', 'Booked')
                    ->whereHas('bookingDetail', function ($detailsQuery) use ($startDateTime, $endDateTime) {
                        $detailsQuery->where(function ($query) use ($startDateTime, $endDateTime) {
                            $query->where('start_datetime', '<', $endDateTime)
                                ->whereRaw('DATE_ADD(start_datetime, INTERVAL number_of_days DAY) > ?', [$startDateTime]);
                        });
                    });
            });
        }

        $packages = $packagesQuery->paginate(10);

        return view('main.client.packages', [
            'packages' => $packages,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    public function bookPackageView(Request $request, $package_id){
        $package = Package::find($package_id);
        
        return view('main.client.book-package')
            ->with(['package' => $package]);
    }

    public function bookStore(Request $request){
        $request->validate([
            'package_id' => 'required|exists:packages,id'
        ]);

        $package = Package::find($request->package_id);

        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'booking_type' => 'required|in:Vehicle,Package',
            'contact_number' => 'required|regex:/^09\d{9}$/',
            'name' => 'required',
            'start_date' => 'required|date|after:'.now()->addDay(),
            'payment_option' => 'required|in:'.Payment::OPTION_FULL_PAYMENT.','.Payment::OPTION_INSTALLMENT,
            'pickup_location' => 'requiredIf:rent_options,With Driver',
            'number_of_person' => 'required|integer|gte:'.$package->minimum_pax
        ]);

        $start_date = Carbon::parse($request->start_date)->addHour(7);
        

        // check if package is available
        if(!$this->isPackageAvailable($request->package_id, $start_date, $request->number_of_days, Booking::STATUS_BOOKED)){
            return redirect()
            ->back()
            ->with('error', "Sorry, this package is already booked from ".Carbon::parse($request->start_date)->format('M d, Y h:i A')." to ".Carbon::parse($request->start_date)->addDays($request->number_of_days)->format('M d, Y h:i A').". Please choose a different date or package.")
            ->withInput();
        }

        // check if has double booking
        if(!$this->checkPackageDoubleBooking($request->vehicle_id, Carbon::parse($request->start_date)->addHours(1)->toDateTime(), $request->number_of_days, Booking::STATUS_PENDING)){
            return redirect()
            ->back()
            ->withErrors(['error' => "It appears you already have a booking for these dates."])
            ->withInput();
        }

        return DB::transaction(function () use ($request, $package, $start_date) {

            
            $computed_price = $package->price_per_person * $request->number_of_person;

            $booking = Booking::create([
                'transaction_number' => time().auth()->user()->id,
                'booking_type' => $request->booking_type,
                'user_id' => auth()->user()->id,
                'contact_number' => $request->contact_number,
                'name' => $request->name,
                'package_id' => $request->package_id,
                'computed_price' => $computed_price,
                'status' => Booking::STATUS_PENDING,
                // 'payment_status' => Payment::STATUS_PENDING
            ]);

            BookingDetail::create([
                'booking_id' => $booking->id,
                'start_datetime' => $start_date,
                'number_of_days' => $package->package_duration,
                'pickup_location' => $request->pickup_location,
                'number_of_persons' => $request->number_of_person
            ]);

            BookingLog::create([
                'booking_id' => $booking->id,
                'log' => auth()->user()->name.' Created the booking',
            ]);

            $this->_createPayments($booking, $request);

            Mail::to($package->user->email)->send(new BookingUpdate($booking, 'You have new vehicle booking.', $package->user, route('org.bookings.index')));
            
            return redirect()->route('client.bookings');   
        });
    }

    public function refundView(Request $request, $booking_id){
        $booking = Booking::find($booking_id);

        if(!$booking){
            return redirect()->back()->with('error', 'Invalid booking.');
        }

        $paid_amount = $booking->payments->where("payment_status", Payment::STATUS_PAID)->sum("amount");
        $refundable_amount = $paid_amount - (($booking->computed_price / 2) * 0.05);

        if($paid_amount <= 0){
            return redirect()->back()->with('error', 'No payment has been made for this booking.');
        }

        return view('main.client.bookings.refund')
            ->with([
                'booking' => $booking,
                'refundable_amount' => $refundable_amount,
                'paid_amount' => $paid_amount
            ]);
    }

    public function storeRefund(Request $request, $booking_id){

        $request->validate([
            'gcash_number' => 'required|numeric|digits:11|starts_with:09',
            'gcash_name' => 'required',
            'email' => 'required|email'
        ]);

        $booking = Booking::find($booking_id);

        if(!$booking){
            return redirect()->back()->with('error', 'Invalid booking.');
        }

        $paid_amount = $booking->payments->where("payment_status", Payment::STATUS_PAID)->sum("amount");
        $refundable_amount = $paid_amount - (($booking->computed_price / 2) * 0.05);

        if($paid_amount <= 0){
            return redirect()->back()->with('error', 'No payment has been made for this booking.');
        }

        Refund::create([
            'booking_id' => $booking->id,
            'amount' => $refundable_amount,
            'gcash_number' => $request->gcash_number,
            'gcash_name' => $request->gcash_name,
            'email' => $request->email,
            'status' => Refund::STATUS_PENDING
        ]);

        return redirect()->route('client.bookings')->with('success', 'Refund request has been submitted.');
        
    }

    public function storeFeedback(Request $request){
        if(!$request->booking_id) {
            return redirect()->back()->with('error', 'An unexpected error occurred while attempting to save your feedback. Please try again later.');
        }

        $booking = Booking::find($request->booking_id);

        if(!$booking){
            return redirect()->back()->with('error', 'Invalid booking.');
        }

        $request->validateWithBag('feedback_create',[
            'review' => 'required',
            'rating' => 'required'
        ]);

        if($booking->status != Booking::STATUS_COMPLETED){
            return redirect()->back()->with('error', 'You cannot give feedback for this booking.');
        }

        return DB::transaction(function () use ($request, $booking) {
            Feedback::create([
                'booking_id' => $booking->id,
                'review' => $request->review,
                'rating' => $request->rating
            ]);

            return redirect()->back()->with('success', 'Feedback submitted successfully.');
        });
    }


    // other functions
    function _createPayments(Booking $booking, Request $request){
        if($request->payment_option == Payment::OPTION_FULL_PAYMENT){
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->computed_price,
                'payment_status' => Payment::STATUS_PENDING,
                'payment_exp' => now()->addDay()->greaterThan($booking->bookingDetail->start_datetime) ? $booking->bookingDetail->start_datetime : now()->addDay(),
            ]);
        }
        else if($request->payment_option == Payment::OPTION_INSTALLMENT){
            $downpayment = $booking->computed_price / 2;

            Payment::create([
                'booking_id' => $booking->id,
                'is_downpayment' => true,
                'amount' => $downpayment,
                'payment_status' => Payment::STATUS_PENDING,
                'payment_exp' => now()->addDay()->greaterThan($booking->bookingDetail->start_datetime) ? $booking->bookingDetail->start_datetime : now()->addDay(),
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->computed_price - $downpayment,
                'payment_status' => Payment::STATUS_PENDING,
                'payment_exp' => $booking->bookingDetail->start_datetime,
            ]);
        }
    }

    function isVehicleAvailable($vehicle_id, $start_datetime, $number_of_days, $status) {
        $end_datetime = Carbon::parse($start_datetime)->addDays($number_of_days);
    
        $overlappingBookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where('bookings.vehicle_id', $vehicle_id)
            ->where('bookings.status', $status)
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where(function ($q) use ($start_datetime) {
                    $q->where('booking_details.start_datetime', '<=', $start_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) > ?', [$start_datetime]);
                })
                ->orWhere(function ($q) use ($end_datetime) {
                    $q->where('booking_details.start_datetime', '<', $end_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) >= ?', [$end_datetime]);
                });
            })
            ->exists();
    
        return !$overlappingBookings; // Returns true if no overlap, meaning the vehicle is available
    }

    function isPackageAvailable($package_id, $start_datetime, $number_of_days, $status) {
        $end_datetime = Carbon::parse($start_datetime)->addDays($number_of_days);
    
        $overlappingBookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where('bookings.package_id', $package_id)
            ->where('bookings.status', $status)
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where(function ($q) use ($start_datetime) {
                    $q->where('booking_details.start_datetime', '<=', $start_datetime)
                      ->whereRaw('DATE_SUB(DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY), INTERVAL 9 HOUR) > ?', [$start_datetime]);
                })
                ->orWhere(function ($q) use ($end_datetime) {
                    $q->where('booking_details.start_datetime', '<', $end_datetime)
                      ->whereRaw('DATE_SUB(DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY), INTERVAL 9 HOUR) >= ?', [$end_datetime]);
                });
            })
            ->exists();
    
        return !$overlappingBookings; // Returns true if no overlap, meaning the vehicle is available
    }

    function checkDoubleBooking($vehicle_id, $start_datetime, $number_of_days, $status) {
        $end_datetime = Carbon::parse($start_datetime)->addDays($number_of_days);
    
        $overlappingBookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where('bookings.vehicle_id', $vehicle_id)
            ->where('bookings.user_id', auth()->user()->id)
            ->where('bookings.status', $status)
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where(function ($q) use ($start_datetime) {
                    $q->where('booking_details.start_datetime', '<=', $start_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) > ?', [$start_datetime]);
                })
                ->orWhere(function ($q) use ($end_datetime) {
                    $q->where('booking_details.start_datetime', '<', $end_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) >= ?', [$end_datetime]);
                });
            })
            ->exists();
    
        return !$overlappingBookings; // Returns true if no overlap, meaning the vehicle is available
    }

    function checkPackageDoubleBooking($package_id, $start_datetime, $number_of_days, $status) {
        $end_datetime = Carbon::parse($start_datetime)->addDays($number_of_days)->subHours(2);
    
        $overlappingBookings = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->where('bookings.package_id', $package_id)
            ->where('bookings.user_id', auth()->user()->id)
            ->where('bookings.status', $status)
            ->where(function ($query) use ($start_datetime, $end_datetime) {
                $query->where(function ($q) use ($start_datetime) {
                    $q->where('booking_details.start_datetime', '<=', $start_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) > ?', [$start_datetime]);
                })
                ->orWhere(function ($q) use ($end_datetime) {
                    $q->where('booking_details.start_datetime', '<', $end_datetime)
                      ->whereRaw('DATE_ADD(booking_details.start_datetime, INTERVAL booking_details.number_of_days DAY) >= ?', [$end_datetime]);
                });
            })
            ->exists();
    
        return !$overlappingBookings; // Returns true if no overlap, meaning the vehicle is available
    }


}
