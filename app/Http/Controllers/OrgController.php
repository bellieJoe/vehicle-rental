<?php

namespace App\Http\Controllers;

use App\Mail\BookingUpdate;
use App\Mail\RefundInvoice;
use App\Models\AdditionalRate;
use App\Models\Booking;
use App\Models\BookingLog;
use App\Models\CancellationDetail;
use App\Models\CancellationRate;
use App\Models\D2dSchedule;
use App\Models\D2dVehicle;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Route;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\type;

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
        $d2dVehicleIds = D2dVehicle::where('user_id', auth()->user()->id)->pluck('id');
        $scheduleIds = D2dSchedule::whereIn('d2d_vehicle_id', $d2dVehicleIds)->pluck('id');


        $query = Booking::query();

        if ($status) {
            $query->where('status', $status);
        }

        $query->where(function ($q) use ($vehicleIds, $packageIds, $scheduleIds) {
            $q->whereIn('vehicle_id', $vehicleIds)
              ->orWhereIn('package_id', $packageIds)
              ->orWhereIn('d2d_schedule_id', $scheduleIds);
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

            $discount = $request->discount;
    
            $action = $request->action;
            $booking = Booking::find($booking_id);
    
            if($action === "APPROVE"){
                $booking->update([
                    'status' => "To Pay"
                ]);
                if($discount){
                    $booking->update([
                        'discount' => $discount,
                        'computed_price' => $booking->computed_price - $discount
                    ]);
                }
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
        $d2d_vehicle_ids = D2dVehicle::where('user_id', auth()->user()->id)->pluck('id');
        $d2d_schedule_ids = D2dSchedule::whereIn('d2d_vehicle_id', $d2d_vehicle_ids)->pluck('id');
        $bookings_ids = Booking::whereIn('package_id', $package_ids)
        ->orWhereIn('vehicle_id', $vehicle_ids)
        ->orWhereIn('d2d_schedule_id', $d2d_schedule_ids)
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

    //  ROUTES
    public function routes(){
        $routes = Route::where([
            'user_id' => auth()->user()->id
        ])->paginate(10);

        return view("main.org.routes.index")
        ->with([
            "routes" => $routes
        ]);
    }

    public function routeCreate(){
        return view("main.org.routes.create");
    }

    public function routeStore(Request $request){
        $request->validateWithBag('route_create',[
            "from_address" => "required",
            "to_address" => "required",
            "rate" => "required"
        ]);

        Route::create([
            "from_address" => $request->from_address,
            "to_address" => $request->to_address,
            "rate" => $request->rate,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->back()->with("success", "Route created successfully");
    }

    public function routeEdit($route_id){
        $route = Route::find($route_id);

        return view("main.org.routes.edit")
        ->with([
            "route" => $route
        ]);
    }

    public function routeUpdate(Request $request, $route_id){
        $request->validateWithBag('route_update',[
            "from_address" => "required",
            "to_address" => "required",
            "rate" => "required"
        ]);

        Route::find($route_id)->update([
            "from_address" => $request->from_address,
            "to_address" => $request->to_address,
            "rate" => $request->rate
        ]);

        return redirect()->back()->with("success", "Route updated successfully");
    }

    public function routeDelete($route_id){
        if(D2dSchedule::where("route_id", $route_id)->exists()){
            return redirect()->back()->with("error", "Route cannot be deleted as it has a Door to Door schedule.");
        }
        Route::find($route_id)->delete();
        return redirect()->back()->with("success", "Route deleted successfully"); 
    }

    public function additionalRates($route_id){
        $route = Route::find($route_id);
        $rates = AdditionalRate::where([
            "user_id" => auth()->user()->id,
            "route_id" => $route_id,
            "type" => AdditionalRate::TYPE_DOOR_TO_DOOR
        ])->get();

        return view("main.org.routes.additional-rates.index")
        ->with([
            "route" => $route,
            "rates" => $rates
        ]);
    }

    public function additionalRateCreate($route_id){
        $route = Route::find($route_id);
        
        return view("main.org.routes.additional-rates.create")
        ->with([
            "route" => $route
        ]);
    }

    public function additionalRateStore(Request $request , $route_id){
        $request->validate([
            "name" => "required",
            "rate" => "required"
        ]);

        AdditionalRate::create([
            "user_id" => auth()->user()->id,
            "type" => AdditionalRate::TYPE_DOOR_TO_DOOR,
            "rate" => $request->rate,
            "name" => $request->name,
            "route_id" => $route_id
        ]);

        return redirect()->back()->with("success", "Additional rate created successfully");
    }

    public function additionalRateEdit($additional_rate_id){
        $rate = AdditionalRate::find($additional_rate_id);
        $route = Route::find($rate->route_id);

        return view("main.org.routes.additional-rates.edit")
        ->with([
            "rate" => $rate,
            "route" => $route
        ]);
    }   

    public function additionalRateUpdate(Request $request, $additional_rate_id){
        $request->validate([
            "name" => "required",
            "rate" => "required"
        ]);

        AdditionalRate::find($additional_rate_id)->update([
            "name" => $request->name,
            "rate" => $request->rate
        ]);

        return redirect()->back()->with("success", "Additional rate updated successfully");
    }

    public function additionalRateDelete($additional_rate_id){
        AdditionalRate::find($additional_rate_id)->delete();
        return redirect()->back()->with("success", "Additional rate deleted successfully");
    }

    public function d2dVehicles(){
        $d2d_vehicles = D2dVehicle::where([
            "user_id" => auth()->user()->id
        ])->paginate(10);
        return view("main.org.d2d-vehicles.index")
        ->with([
            "d2d_vehicles" => $d2d_vehicles
        ]);
    }

    public function d2dVehicleCreate(){
        return view("main.org.d2d-vehicles.create");
    }

    public function d2dVehicleStore(Request $request){
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('d2d_vehicle_create', [
                "name" => "required",
                "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
                "max_cap" => "required"
            ]);
    
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/d2d-vehicles'), $image_name);
    
            D2dVehicle::create([
                "name" => $request->name,
                "image" => $image_name,
                "max_cap" => $request->max_cap,
                "user_id" => auth()->user()->id
            ]);
    
            return redirect()->back()->with("success", "Doo2 to Door vehicle created successfully");
        });
    }

    public function d2dVehicleEdit($d2d_vehicle_id){
        $d2d_vehicle = D2dVehicle::find($d2d_vehicle_id);
        return view("main.org.d2d-vehicles.edit")
        ->with([
            "d2d_vehicle" => $d2d_vehicle
        ]);
    }

    public function d2dVehicleUpdate(Request $request, $d2d_vehicle_id){
        return DB::transaction(function () use ($request, $d2d_vehicle_id) {
            $request->validateWithBag('d2d_vehicle_update', [
                "name" => "required",
                "image" => "image|mimes:jpeg,png,jpg|max:2048",
                "max_cap" => "required"
            ]);

            $d2d_vehicle = D2dVehicle::find($d2d_vehicle_id);
    
            $image = $request->file('image');
            if($image){
                $image_name = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/d2d-vehicles'), $image_name);    
                $d2d_vehicle->update([
                    "image" => $image_name
                ]);
            }

            $d2d_vehicle->update([
                "name" => $request->name,
                "max_cap" => $request->max_cap
            ]);

            return redirect()->back()->with("success", "Doo2 to Door vehicle updated successfully");
        });
    }
    public function d2dVehicleDelete($d2d_vehicle_id){
        if(D2dSchedule::where('d2d_vehicle_id', $d2d_vehicle_id)->exists()){
            return redirect()->back()->with("error", "Doo2 to Door vehicle cannot be deleted because it has associated schedules");
        }
        D2dVehicle::find($d2d_vehicle_id)->delete();
        return redirect()->back()->with("success", "Doo2 to Door vehicle deleted successfully");
    }

    public function getD2dSchedules($d2d_vehicle_id){
        $schedules = D2dSchedule::select('id', 'd2d_vehicle_id', 'route_id', 'depart_date')
            ->where('d2d_vehicle_id', $d2d_vehicle_id)
            ->whereNull('deleted_at') // Exclude deleted schedules
            ->with(['d2d_vehicle', 'route'])
            ->get();

        // Transform data for FullCalendar
        $events = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => "Vehicle: {$schedule->d2d_vehicle->name} | Route: {$schedule->route->from_address} to {$schedule->route->to_address}",
                'start' => $schedule->depart_date,
            ];
        });

        return response()->json($events);
    }

    // d2dSchedules
    public function d2dSchedules($d2d_vehicle_id){
        $d2d_vehicle = D2dVehicle::find($d2d_vehicle_id);
        $schedules = D2dSchedule::where([
            "d2d_vehicle_id" => $d2d_vehicle_id,
            ["depart_date", ">=", now()]
        ])
        ->with(["route"])
        ->paginate(10);

        return view("main.org.d2d-vehicles.d2d-schedules.index")
        ->with([
            "d2d_vehicle" => $d2d_vehicle,
            "schedules" => $schedules
        ]);
    }
    // d2dScheduleCreate
    public function d2dScheduleCreate($d2d_vehicle_id){
        $d2d_vehicle = D2dVehicle::find($d2d_vehicle_id);
        $routes = Route::where([
            "user_id" => auth()->user()->id
        ])->get();

        return view("main.org.d2d-vehicles.d2d-schedules.create")
        ->with([
            "d2d_vehicle" => $d2d_vehicle,
            "routes" => $routes
        ]);
    }
    
    // d2dScheduleStore
    public function d2dScheduleStore(Request $request, $d2d_vehicle_id){
        $request->validate( [
            "depart_date" => "required|date|after:".now()->addDay(),
            "route_id" => "required|exists:routes,id"
        ]);

        return DB::transaction(function () use ($request, $d2d_vehicle_id) {
            $exist = D2dSchedule::where([
                "d2d_vehicle_id" => $d2d_vehicle_id,
                "depart_date" => $request->depart_date
            ])->first();

            if($exist){
                return redirect()->back()->with("error", "Schedule already exist");
            }

            D2dSchedule::create([
                "d2d_vehicle_id" => $d2d_vehicle_id,
                "depart_date" => $request->depart_date,
                "route_id" => $request->route_id
            ]);

            return redirect()->back()->with("success", "Schedule created successfully");

        });
    }

    // d2dScheduleDelete
    public function d2dScheduleDelete($d2d_vehicle_id, $d2d_schedule_id){
        if(Booking::where("d2d_schedule_id", $d2d_schedule_id)->exists()){
            return redirect()->back()->with("error", "Schedule cannot be deleted because it has associated bookings");
        }
        $d2sSched = D2dSchedule::find($d2d_schedule_id);
        if(!$d2sSched){
            return redirect()->back()->with("error", "Schedule not found");
        }
        $d2sSched->delete();
        return redirect()->back()->with("success", "Schedule deleted successfully");
    }

    // CANCELLATION RATES
    public function cancellationRates(Request $request){
        $rates = CancellationRate::where([
            "user_id" => auth()->user()->id
        ])->get();

        return view("main.org.cancellation-rates.index")->with([
            "rates" => $rates
        ]);
    }

    public function cancellationRateCreate(){
        return view("main.org.cancellation-rates.create");
    }

    public function cancellationRateStore(Request $request){
        $request->validate([
            "remaining_days" => "required",
            "percentage" => "required"
        ]);

        $user = auth()->user();

        $rate = CancellationRate::where([
            "user_id" => $user->id,
            "remaining_days" => $request->remaining_days
        ])->first();

        if($rate){
            return redirect()->back()->with("error", "Cancellation rate already exist");
        }

        CancellationRate::create([
            "user_id" => $user->id,
            "remaining_days" => $request->remaining_days,
            "percent" => $request->percentage
        ]);

        return redirect()->route("org.cancellation-rates.index")->with("success", "Cancellation rate created successfully");
    }

    // cancellationRateEdit
    public function cancellationRateEdit($cancellation_rate_id){
        $rate = CancellationRate::find($cancellation_rate_id);
        return view("main.org.cancellation-rates.edit")->with([
            "rate" => $rate
        ]);
    }

    // cancellationRateUpdate
    public function cancellationRateUpdate(Request $request, $cancellation_rate_id){
        $request->validate([
            "remaining_days" => "required",
            "percentage" => "required"
        ]);

        $rate = CancellationRate::find($cancellation_rate_id);
        $rate->remaining_days = $request->remaining_days;
        $rate->percent = $request->percentage;
        $rate->save();

        return redirect()->route("org.cancellation-rates.index")->with("success", "Cancellation rate updated successfully");
    }

    // cancellationRateDelete
    public function cancellationRateDelete($cancellation_rate_id){
        $rate = CancellationRate::find($cancellation_rate_id);
        $rate->delete();
        return redirect()->route("org.cancellation-rates.index")->with("success", "Cancellation rate deleted successfully");
    }


    // approveCancellation
    public function approveCancellation($booking_id){
        $booking = Booking::find($booking_id);
        $booking->status = Booking::STATUS_CANCELLED;
        $booking->save();

        CancellationDetail::where([
            "booking_id" => $booking_id
        ])
        ->update([
            "status" => Booking::STATUS_CANCEL_APPROVED
        ]);

        $client = $booking->user;

        Mail::to($client->email)->send(new BookingUpdate($booking, "Your booking has been cancellation request was approved. To request a refund, please go to your bookings page and provide the necessary information. ", $client, route('client.bookings')));

        return redirect()->back()->with("success", "Booking cancellation has been approved successfully.");
    }

    // rejectCancellation
    public function rejectCancellation($booking_id){
        $booking = Booking::find($booking_id);

        CancellationDetail::where([
            "booking_id" => $booking_id
        ])
        ->update([
            "status" => Booking::STATUS_CANCEL_REJECTED
        ]);

        $client = $booking->user;

        Mail::to($client->email)->send(new BookingUpdate($booking, "Your booking cancellation request was rejected. Please try again.", $client, route('client.bookings')));

        return redirect()->back()->with("success", "Booking cancellation has been rejected successfully.");
    }

    // extendBooking
    public function extendBooking(Request $request, $booking_id){
        $request->validate([
            "extend_days" => "required|integer|min:1"
        ]);

        return DB::transaction(function () use ($request, $booking_id){
            
            $booking = Booking::find($booking_id);
    
            if(!$booking || $booking->status != Booking::STATUS_BOOKED || $booking->booking_type != "Vehicle"){
                return redirect()->back()->with("error", "Invalid booking");
            }
    
            $start_datetime = Carbon::parse($booking->bookingDetail->start_datetime)->addDays($booking->bookingDetail->number_of_days);
            if(!Vehicle::isVehicleAvailable($booking->vehicle_id, $start_datetime, ($request->extend_days), Booking::STATUS_BOOKED)){
                return redirect()->back()->with("error", "Vehicle is not available at the extended number of days.");
            }   
    
            $additional_computed_price = 0;
            if($booking->bookingDetail->with_driver == 1){
                $additional_computed_price = $request->extend_days * $booking->vehicle->rate_w_driver;
            }
            else {
                $additional_computed_price = $request->extend_days * $booking->vehicle->rate;
            }
    
            $booking->update([
                "status" => Booking::STATUS_BOOKED,
                "computed_price" => $booking->computed_price + $additional_computed_price
            ]);
    
            $booking->bookingDetail->update([
                "number_of_days" => $request->extend_days + $booking->bookingDetail->number_of_days
            ]);
    
            $payment_exp = now()->addDay()->greaterThan($booking->bookingDetail->start_datetime) ? $booking->bookingDetail->start_datetime : now()->addDay();
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $additional_computed_price,
                'payment_status' => Payment::STATUS_PENDING,
                'payment_exp' => $payment_exp,
            ]);
    
            Mail::to($booking->user->email)->send(new BookingUpdate($booking, "Your booking has been extended successfully by " . $request->extend_days . " days.", $booking->user, route('client.bookings')));
    
            return redirect()->back()->with("success", "Booking extended successfully");
        });
    }

    public function extendBookingView(Request $request, $booking_id){
        $booking = Booking::find($booking_id);
        if(!$booking || $booking->status != Booking::STATUS_BOOKED || $booking->booking_type != "Vehicle"){
            return redirect()->back()->with("error", "Invalid booking");
        }
        $vehicle = Vehicle::find($booking->vehicle_id);
        return view("main.org.bookings.extend")
        ->with([
            "booking" => $booking,
            "vehicle" => $vehicle
        ]);
    }

    

}
