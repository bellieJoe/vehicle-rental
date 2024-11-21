<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    //
    use SoftDeletes;
    
    public function index(){
        $_query = request()->query('query');
        $vehicles = Vehicle::where('user_id', auth()->user()->id)
            ->where(function($query) use ($_query) {
                $query->where('model', 'LIKE', "%{$_query}%")
                    ->orWhere('brand', 'LIKE', "%{$_query}%")
                    ->orWhere('plate_number', 'LIKE', "%{$_query}%");
            })
            ->with([
                'vehicleCategory',
                'user.organisation'
            ])
            ->withCount([
                'bookings'
            ])
            ->paginate(10);
        $categories = VehicleCategory::where("user_id", auth()->user()->id)->get();

        return view('main.org.vehicles.vehicles')->with([
            'vehicles'=> $vehicles,
            "categories" => $categories
        ]);
    }

    public function create(Request $request){
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('vehicle_create', [
                "brand" => "required",
                "model" => "required",
                "plate_number" => "required|unique:vehicles,plate_number",
                "vehicle_category_id" => "required|exists:vehicle_categories,id",
                "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
                "rent_options" => "required|in:With Driver,Without Driver,Both",
                "rate" => "required|numeric|min:0",
                "rate_w_driver" => "nullable|required_if:rent_options,With Driver,Both|numeric|min:0",
            ]);
    
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/vehicles'), $imageName);
    
            Vehicle::create([
                "brand" => $request->brand,
                "model" => $request->model,
                "plate_number" => $request->plate_number,
                "vehicle_category_id" => $request->vehicle_category_id,
                "image" => $imageName,
                "rent_options" => $request->rent_options,
                "rate" => $request->rate,
                "rate_w_driver" => $request->rent_options === 'Without Driver' ? null : $request->rate_w_driver,
                "user_id" => auth()->user()->id,
            ]);
    
            return redirect()->back()->with('success', 'Vehicle created successfully');
        });
    }

    public function setAvailability(Request $request, $vehicle_id){

        $vehicle = Vehicle::find($vehicle_id);

        $vehicle->update([
            "is_available" => $request->is_available === 'true' ? 1 : 0
        ]);

        return redirect()->back()->with('success', 'Vehicle availability updated successfully');
    }

    public function update(Request $request){
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('vehicle_update', [
                "brand" => "required",
                "model" => "required",
                "plate_number" => [
                    "required", 
                    Rule::unique('vehicles', 'plate_number')->ignore($request->id), 
                ],
                "vehicle_category_id" => "required|exists:vehicle_categories,id",
                "image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                "rent_options" => "required|in:With Driver,Without Driver,Both",
                "rate" => "required|numeric|min:0",
                "rate_w_driver" => "nullable|required_if:rent_options,With Driver,Both|numeric|min:0"
            ]);
    
            $vehicle = Vehicle::find($request->id); 

            if ($request->hasFile('image')) {
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('images/vehicles'), $imageName);
                $vehicle->update([
                    "image" => $imageName
                ]);
            }
    
            $vehicle->update([
                "brand" => $request->brand,
                "model" => $request->model,
                "plate_number" => $request->plate_number,
                "vehicle_category_id" => $request->vehicle_category_id,
                "rent_options" => $request->rent_options,
                "rate" => $request->rate,
                "rate_w_driver" => $request->rent_options === 'Without Driver' ? null : $request->rate_w_driver,
            ]);

            return redirect()->back()->with('success', 'Vehicle updated successfully');
        });
    }

    public function delete(Request $request){
        $request->validateWithBag('vehicle_delete', [
            'id' => 'required|exists:vehicles,id',
        ]);

        $vehicle = Vehicle::find($request->id);
        $vehicle->delete();
        return redirect()->back()->with('success', 'Vehicle deleted successfully');
    }

    public function apiQuery(Request $request, $user_id) {
        $query = $request->query('query');
    
        $vehicles = Vehicle::where('user_id', $user_id)
            ->where(function($q) use ($query) {
                $q->where('plate_number', 'like', '%' . $query . '%')
                  ->orWhere('model', 'like', '%' . $query . '%')
                  ->orWhere('brand', 'like', '%' . $query . '%');
            })
            ->addSelect(DB::raw("CONCAT(brand, ' ', model, ' ', plate_number) as text"))
            ->get();
    
        return $vehicles;
    }

    public function getVehicleBookings($vehicle_id)
    {
        $bookings = Booking::where('vehicle_id', $vehicle_id)
            ->where('status', 'Booked')
            ->where('start_datetime', '>=', now())
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->select('booking_details.start_datetime', 'booking_details.number_of_days')
            ->get();

        $events = $bookings->map(function ($booking) {
            $start = Carbon::parse($booking->start_datetime);
            $end = $start->copy()->addDays($booking->number_of_days );

            return [
                'title' => 'Booked',
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'backgroundColor' => '#ff0000', // Red color for booked dates
                'borderColor' => '#ff0000',
            ];
        });

        return response()->json($events);
    }
}
