<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\BookingLog;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($request) {
            $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'booking_type' => 'required|in:Vehicle,Package',
                'contact_number' => 'required|regex:/^09\d{9}$/',
                'name' => 'required',
                'start_date' => 'required|date|after:'.now()->addDay(),
                'number_of_days' => 'required|integer|min:1',
                'rent_options' => 'required|in:With Driver,Without Driver',
                'payment_method' => 'required|in:Cash,Online'
            ]);

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
                'status' => 'Pending',
            ]);

            BookingDetail::create([
                'booking_id' => $booking->id,
                'start_datetime' => $request->start_date,
                'number_of_days' => $request->number_of_days,
                'with_driver' => $request->rent_options === 'With Driver',
            ]);

            BookingLog::create([
                'booking_id' => $booking->id,
                'log' => auth()->user()->name.' Created the booking',
            ]);
            
            return redirect()->route('client.bookings');   
        });
    }

    public function bookings(Request $request)
    {
        $bookings = Booking::where('user_id', auth()->user()->id)
            ->with([
                'vehicle.user.organisation',
                'vehicle.vehicleCategory',
                'bookingDetail'
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);    

        // return $bookings;
        return view('main.client.bookings')
            ->with([
                'bookings'=> $bookings
            ]);
    }
}
