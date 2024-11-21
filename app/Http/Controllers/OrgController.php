<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Gallery;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrgController extends Controller
{
    public function bookings(Request $request)
    {
        $vehicleIds = Vehicle::where('user_id', auth()->user()->id)->pluck('id');
        $bookings = Booking::whereIn('vehicle_id', $vehicleIds)
            ->with([
                'vehicle.user.organisation',
                'vehicle.vehicleCategory',
            ])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);    

        // return $bookings;
        return view('main.org.bookings.bookings')
            ->with([
                'bookings'=> $bookings
            ]);
    }

    public function editBooking(Request $request, $booking_id)
    {
        $booking = Booking::find($booking_id);
        return view('main.org.bookings.edit')
            ->with([
                'booking' => $booking
            ]);
    }

    public function updateBooking(Request $request, $booking_id)
    {
        return DB::transaction(function () use ($request, $booking_id) {
            $request->validate([
                'action' => 'required|in:APPROVE,REJECT'
            ]);
    
            $action = $request->action;
            $booking = Booking::find($booking_id);
    
            if($action === "APPROVE"){
                $booking->update([
                    'status' => "To Pay"
                ]);
                BookingLog::create([
                    'booking_id' => $booking_id,
                    'log' => "Booking was approved by " . auth()->user()->name
                ]);

                // add mail
                Mail::to($booking->user->email)->send(new BookingUpdate($booking, "Congratulations! Your booking has been approved. To secure your reservation, please proceed with the payment at your earliest convenience. You can view your booking details and make a payment by visiting your bookings dashboard.", $booking->user, route('client.bookings')));
            }
            if($action === "REJECT"){
                $booking->update([
                    'status' => "Rejected"
                ]);
                BookingLog::create([
                    'booking_id' => $booking_id,
                    'log' => "Booking was rejected by " . auth()->user()->name
                ]);

                // add mail
            }
            $booking->save();

            return redirect()->route('org.bookings.index')->with('success', 'Booking updated successfully');
        });
    }

    public function galleries(Request $request)
    {
        $galleries = Gallery::where('organisation_id', auth()->user()->organisation->id)->paginate(10);
        return view('main.org.galleries.index')
            ->with([
                'galleries' => $galleries
            ]);
    }

    public function galleryStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required'
        ]);

        $image = $request->file('image');
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/images/galleries'), $image_name);    

        Gallery::create([
            'title' => $request->title,
            'image' => $image_name,
            'description' => $request->description,
            'organisation_id' => auth()->user()->organisation->id
        ]); 

        return redirect()->route('org.galleries.index')->with('success', 'Gallery created successfully');
    }

    public function galleryCreate(Request $request)
    {
        return view('main.org.galleries.create');
    }

    public function galleryEdit(Request $request, $gallery_id)
    {
        $gallery = Gallery::find($gallery_id);
        return view('main.org.galleries.edit')
            ->with([
                'gallery' => $gallery
            ]);
    }

    public function galleryUpdate(Request $request, $gallery_id)
    {
        return DB::transaction(function () use ($request, $gallery_id) {
            $request->validate([
                'title' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
                'description' => 'required'
            ]);
    
            $image = $request->file('image');
            if($image){
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/images/galleries'), $image_name);    
                Gallery::find($gallery_id)->update([
                    'image' => $image_name
                ]);
            }
    
            Gallery::find($gallery_id)->update([
                'title' => $request->title,
                'description' => $request->description
            ]); 
    
            return redirect()->route('org.galleries.index')->with('success', 'Gallery updated successfully');
        });
    }

    public function paymentsView(Request $request, $booking_id) {

        $booking = Booking::find($booking_id);

        return view('main.org.bookings.payments')
            ->with([
                'booking' => $booking
            ]);
    }

    public function approvePayment(Request $request, $payment_id) {
        return DB::transaction(function () use ($request, $payment_id) {

            $payment = Payment::find($payment_id);
            
            $payment->update([
                'payment_status' => Payment::STATUS_PAID,
                'date_paid' => now()
            ]);
            
            $client = $payment->booking->user;

            Mail::to($client->email)->send(new BookingUpdate($payment->booking, "Your payment of " . $payment->amount . " through " . $payment->payment_method . " has been successfully approved.", $client, route('client.bookings')));

            $booking = $payment->booking;
            if($payment->is_downpayment || $booking->payments_count == 0){
                $booking->update([
                    'status' => Booking::STATUS_BOOKED,
                ]); 
            }

            Mail::to($client->email)->send(new BookingUpdate($payment->booking, "Your booking has been secured.", $client, route('client.bookings')));

            return redirect()->back()->with('success', 'Payment updated successfully');
        });
    }

    public function invalidPayment(Request $request, $payment_id) {
        return DB::transaction(function () use ($request, $payment_id) {
    
            $payment = Payment::find($payment_id);
            
            $payment->update([
                'payment_status' => Payment::STATUS_GCASH_INVALID
            ]);
            
            $client = $payment->booking->user;

            Mail::to($client->email)->send(new BookingUpdate($payment->booking, "Your payment of " . $payment->amount . " through " . $payment->payment_method . " is invalid. Please make sure to send the correct Gcash transaction number.", $client, route('client.bookings')));

            return redirect()->back()->with('success', 'Payment updated successfully');
        });
    }

    public function approveCashPayment(Request $request, $payment_id){
        return DB::transaction(function () use ($request, $payment_id) {

            $payment = Payment::find($payment_id);
            
            $payment->update([
                'payment_status' => Payment::STATUS_PAID,
                'date_paid' => now(),
                'payment_method' => Payment::METHOD_CASH
            ]);
            
            $client = $payment->booking->user;

            Mail::to($client->email)->send(new BookingUpdate($payment->booking, "Your payment of " . $payment->amount ." through cash"." has been successfully approved.", $client, route('client.bookings')));

            $booking = $payment->booking;
            if($payment->is_downpayment || $booking->payments_count == 0){
                $booking->update([
                    'status' => Booking::STATUS_BOOKED,
                ]); 
            }

            Mail::to($client->email)->send(new BookingUpdate($payment->booking, "Your booking has been secured.", $client, route('client.bookings')));

            return redirect()->back()->with('success', 'Payment updated successfully');
        });
    }
}
