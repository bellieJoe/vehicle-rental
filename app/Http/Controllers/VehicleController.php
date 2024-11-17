<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
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
            ->with('vehicleCategory')
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
                "price_computation" => "required|in:Hourly,Daily,Both",
                "hourly_price" => "nullable|required_if:price_computation,Hourly,Both|numeric|min:0",
                "daily_price" => "nullable|required_if:price_computation,Daily,Both|numeric|min:0"
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
                "price_computation" => $request->price_computation,
                "hourly_price" => $request->price_computation === 'Hourly' || $request->price_computation === 'Both' ? $request->hourly_price : null,
                "daily_price" => $request->price_computation === 'Daily' || $request->price_computation === 'Both' ? $request->daily_price : null,
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
            $request->validateWithBag('vehicle_create', [
                "brand" => "required",
                "model" => "required",
                "plate_number" => ["required", 
                        Rule::unique('vehicles', 'plate_number')->ignore($request->id), 
                ],
                "vehicle_category_id" => "required|exists:vehicle_categories,id",
                "image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                "rent_options" => "required|in:With Driver,Without Driver,Both",
                "price_computation" => "required|in:Hourly,Daily,Both",
                "hourly_price" => "nullable|required_if:price_computation,Hourly,Both|numeric|min:0",
                "daily_price" => "nullable|required_if:price_computation,Daily,Both|numeric|min:0"
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
                "price_computation" => $request->price_computation,
                "hourly_price" => $request->price_computation === 'Hourly' || $request->price_computation === 'Both' ? $request->hourly_price : null,
                "daily_price" => $request->price_computation === 'Daily' || $request->price_computation === 'Both' ? $request->daily_price : null
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
}
