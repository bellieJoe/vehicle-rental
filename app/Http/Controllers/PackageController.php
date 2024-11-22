<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    //
    public function index(Request $request) {   
        $packages = Package::where('user_id', auth()->user()->id)->paginate(10);
        return view('main.org.packages.index')
            ->with('packages', $packages);
    }

    public function create(Request $request) {
        return view('main.org.packages.create');
    }

    public function store(Request $request) {
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('package_create', [
                'package_name' => 'required|string|max:255',
                'price_per_person' => 'required|numeric|min:0',
                'minimum_pax' => 'required|numeric|min:0',
                'package_duration' => 'required|integer|min:1',
                'package_description' => 'required|string',
                'package_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                // 'vehicle_id' => 'required|exists:vehicles,id',
            ]);

            $imageName = time().'.'.$request->package_image->extension();  
            $request->package_image->move(public_path('images/packages'), $imageName);

            Package::create([
                'user_id' => auth()->user()->id,
                'package_name' => $request->package_name,
                'price_per_person' => $request->price_per_person,
                'minimum_pax' => $request->minimum_pax,
                'package_duration' => $request->package_duration,
                'package_description' => $request->package_description,
                'package_image' => $imageName,
                // 'vehicle_id' => $request->vehicle_id
            ]);

            return redirect()->route('org.packages.index')->with('success', 'Package created successfully');
        });
    }

    public function edit(Request $request, $package_id) {
        $package = Package::find($package_id);
        return view('main.org.packages.update')
            ->with('package', $package);
    } 
    
    public function update(Request $request, $package_id) {
        return DB::transaction(function () use ($request, $package_id) {
            $request->validateWithBag('package_update', [
                'package_name' => 'required|string|max:255',
                'price_per_person' => 'required|numeric|min:0',
                'minimum_pax' => 'required|numeric|min:0',
                'package_duration' => 'required|integer|min:1',
                'package_description' => 'required|string',
                'package_image' => 'image|mimes:jpeg,png,jpg|max:2048',
                // 'vehicle_id' => 'required|exists:vehicles,id',
            ]);

            $package = Package::find($package_id);
            $package->package_name = $request->package_name;
            $package->price_per_person = $request->price_per_person;
            $package->minimum_pax = $request->minimum_pax;
            $package->package_duration = $request->package_duration;        
            $package->package_description = $request->package_description;
            if($request->hasFile('package_image')) {
                $imageName = time().'.'.$request->package_image->extension();  
                $request->package_image->move(public_path('images/packages'), $imageName);
                $package->package_image = $imageName;
            }
            // $package->vehicle_id = $request->vehicle_id;
            $package->save();

            return redirect()->route('org.packages.index')->with('success', 'Package updated successfully');
        });
    }

}
