<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleCategoryController extends Controller
{
    //
    public function index(){
        $categories = VehicleCategory::where('user_id', auth()->user()->id)->withCount('vehicles')->paginate(10);

        return view('main.org.vehicles.vehicle-categories')
            ->with('categories', $categories);
    }

    public function create(Request $request){
        $request->validateWithBag('category_create', [
            "category_name" => [
                "required",
                Rule::unique('vehicle_categories', 'category_name')
                    ->ignore($request->id) 
                    ->where('user_id', auth()->user()->id) 
                    ->whereNull('deleted_at'), 
            ],
        ]);

        VehicleCategory::create([
            "category_name" => $request->category_name,
            "user_id" => auth()->user()->id
        ]);
        
        return redirect()->back()->with("message", "Category added successfully");
    }

    public function delete(Request $request){
        $request->validateWithBag('category_delete', [
            'id' => 'required|exists:vehicle_categories,id',
        ]);

        if(Vehicle::where('category_id', $request->id)->exists()){
            return back()->with('error', 'Category has associated vehicles and cannot be deleted.')->withInput();
        }

        $category = VehicleCategory::find($request->id);

        if($category->vehicles->isNotEmpty()){
            return back()->withErrors(['category_delete' => 'Category has associated vehicles and cannot be deleted.'])->withInput();
        }

        $category->delete();

        return redirect()->back()->with("message", "Category deleted successfully");
    }

    public function update(Request $request){
        $request->validateWithBag('category_update', [
            "id" => "required|exists:vehicle_categories,id",
            "category_name" => [
                "required",
                Rule::unique('vehicle_categories', 'category_name')
                    ->ignore($request->id) 
                    ->where('user_id', auth()->user()->id) 
                    ->whereNull('deleted_at'), 
            ],
        ]);

        $category = VehicleCategory::findOrFail($request->id);

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->back()->with("message", "Category updated successfully");
    }

}
