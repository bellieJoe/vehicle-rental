<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Gallery;
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
}
