<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Mail\RefundInvoice;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrgController extends Controller
{

    public function index(Request $request)
    {
        $package_count = Package::where('user_id', auth()->user()->id)->count();
        $vehicle_count = Vehicle::where('user_id', auth()->user()->id)->count();
        $vehicleIds = Vehicle::where('user_id', auth()->user()->id)->pluck('id');
        $packageIds = Package::where('user_id', auth()->user()->id)->pluck('id');
        $booking_count = Booking::whereIn('vehicle_id', $vehicleIds)->orWhereIn('package_id', $packageIds)->count();
        return view('main.org.index')
            ->with([
                'package_count' => $package_count,
                'vehicle_count' => $vehicle_count,
                'booking_count' => $booking_count
            ]); 
    }

    public function bookings(Request $request)
    {
        $status = $request->query('status');
        $vehicleIds = Vehicle::where('user_id', auth()->user()->id)->pluck('id');
        $packageIds = Package::where('user_id', auth()->user()->id)->pluck('id');

        $query = Booking::query();

        if ($status) {
            $query->where('status', $status);
        }

        $query->where(function ($q) use ($vehicleIds, $packageIds) {
            $q->whereIn('vehicle_id', $vehicleIds)
              ->orWhereIn('package_id', $packageIds);
        });

        $query->with([
            'vehicle.user.organisation',
            'vehicle.vehicleCategory',
        ])
        ->orderBy('created_at', 'DESC');

        $bookings = $query->paginate(10);

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

    public function viewRefunds(Request $request) {     
        $package_ids = Package::where('user_id', auth()->user()->id)->pluck('id');
        $vehicle_ids = Vehicle::where('user_id', auth()->user()->id)->pluck('id');
        $bookings_ids = Booking::whereIn('package_id', $package_ids)
        ->orWhereIn('vehicle_id', $vehicle_ids)
        ->pluck('id'); 

        $refunds = Refund::whereIn('booking_id', $bookings_ids)
        ->orderBy('created_at', 'desc')
        ->paginate();

        return view('main.org.refunds.index')
        ->with([
            'refunds' => $refunds  
        ]);
    }

    public function processRefund(Request $request) {
        return DB::transaction(function () use ($request) {
            if(!$request->has('refund_id') || !$request->has('gcash_transaction_number')){ 
                return redirect()->back()->with('error', 'Something went wrong. Please try again.');
            }
    
            $refund = Refund::find($request->refund_id);
    
            if(!$refund){
                return redirect()->back()->with('error', 'Cannot find refund.');
            }
    
            $refund->update([
                'gcash_transaction_number' => $request->gcash_transaction_number,
                'status' => Refund::STATUS_REFUNDED,
                'refunded_at' => now()
            ]);
    
            $booking = $refund->booking;
    
            Mail::to($refund->email)->send(new RefundInvoice($refund));
    
            return redirect()->back()->with('success', 'Refund processed successfully.');
        });
    }

    public function completeBooking(Request $request, $booking_id) {
        return DB::transaction(function () use ($request, $booking_id) {
            $booking = Booking::find($booking_id);  

            if(!$booking){
                return redirect()->back()->with('error', 'Invalid booking.');
            }

            $booking->update([
                'status' => Booking::STATUS_COMPLETED
            ]);

            return redirect()->back()->with('success', 'Booking completed successfully.');
        });
    }

    public function getOwnerBookings($user_id)
    {
        // return User::find($user_id);
        // Fetch bookings for packages owned by the user
        $packageBookings = Booking::whereHas('package', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })
            ->where('status', 'Booked')
            ->where('start_datetime', '>=', now())
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->select('booking_details.start_datetime', 'booking_details.number_of_days', 'package_id')
            ->get();

        // Transform package bookings to calendar events
        $packageEvents = $packageBookings->map(function ($booking) {
            $start = Carbon::parse($booking->start_datetime);
            $end = $start->copy()->addDays($booking->number_of_days)->subHours(9);

            return [
                'title' => 'Package Booked - ' . $booking->package->name,
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'backgroundColor' => '#ff8800', // Orange color for package bookings
                'borderColor' => '#ff8800',
            ];
        });

        // Fetch bookings for vehicles owned by the user
        $vehicleBookings = Booking::whereHas('vehicle', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })
            ->where('status', 'Booked')
            ->where('start_datetime', '>=', now())
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->select('booking_details.start_datetime', 'booking_details.number_of_days', 'vehicle_id')
            ->get();

        // Transform vehicle bookings to calendar events
        $vehicleEvents = $vehicleBookings->map(function ($booking) {
            $start = Carbon::parse($booking->start_datetime);
            $end = $start->copy()->addDays($booking->number_of_days);

            return [
                'title' => 'Vehicle Booked - ' . $booking->vehicle->model,
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'backgroundColor' => '#ff0000', // Red color for vehicle bookings
                'borderColor' => '#ff0000',
            ];
        });

        // Combine package and vehicle events
        return [...$packageEvents, ...$vehicleEvents];

        // Return combined events as JSON response
        return response()->json($allEvents);
    }

    public function resetAttempts(Request $request, $payment_id) {
        $payment = Payment::find($payment_id);
        $payment->update([
            'attempts' => 0
        ]);

        Mail::to($payment->booking->user->email)->send(new BookingUpdate($payment->booking, "Payment attempts reset successfully.", $payment->booking->user, route('client.bookings')));

        return redirect()->back()->with('success', 'Payment attempts reset successfully.');
    }

}
