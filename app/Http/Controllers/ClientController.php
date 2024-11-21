<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingLog;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function vehicles(Request $request)
    {
        $vehicles = Vehicle::where('is_available', 1)
        ->with([
            'vehicleCategory',  
            'user.organisation',   
        ])
        ->paginate(10);

        return view('main.client.vehicles', [
            'vehicles' => $vehicles
        ]);
    }

    public function rentView(Request $request, $vehicle_id)
    {
        $vehicle = Vehicle::find($vehicle_id);
        
        return view('main.client.rent')
            ->with(['vehicle' => $vehicle]);
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
            'payment_option' => 'required|in:'.Payment::OPTION_FULL_PAYMENT.','.Payment::OPTION_INSTALLMENT,
            'pickup_location' => 'requiredIf:rent_options,With Driver',
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

            $vehicle = Vehicle::find($request->vehicle_id);
            $computed_price = $request->rent_options === 'Without Driver' ? $vehicle->rate * $request->number_of_days : $vehicle->rate_w_driver * $request->number_of_days;

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
        $bookings = Booking::where('user_id', auth()->user()->id)
            ->with([
                'vehicle.user.organisation',
                'vehicle.vehicleCategory',
                'bookingDetail',
                'bookingLogs'
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);    

        // return $bookings;
        
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

            if(in_array($booking->status, [Booking::STATUS_CANCELLED, Booking::STATUS_REJECTED, Booking::STATUS_COMPLETED, Booking::STATUS_IN_PROGRESS])){
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


}
