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
                'payment_status' => Payment::STATUS_PENDING
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

}
