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
                'package_price' => 'required|numeric|min:0',
                'package_duration' => 'required|integer|min:1',
                'package_description' => 'required|string',
                'package_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'vehicle_id' => 'required|exists:vehicles,id',
            ]);

            $imageName = time().'.'.$request->package_image->extension();  
            $request->image->move(public_path('images/packages'), $imageName);

            Package::create([
                'user_id' => auth()->user()->id,
                'package_name' => $request->package_name,
                'package_price' => $request->package_price,
                'package_duration' => $request->package_duration,
                'package_description' => $request->package_description,
                'package_image' => $imageName,
                'vehicle_id' => $request->vehicle_id
            ]);

            return redirect()->route('org.packages.index')->with('success', 'Package created successfully');
        });
    }

}
