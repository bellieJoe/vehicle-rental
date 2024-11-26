<?php

namespace App\Http\Controllers;

use App\Models\AdditionalRate;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;

class AdditionalRateController extends Controller
{
    //
    public function index(Request $request) {

        $additional_rates = AdditionalRate::where('user_id', auth()->user()->id)->get();

        return view('main.org.additional-rates.index')
            ->with('additional_rates', $additional_rates);
    }

    public function createRental(){
        $categories = VehicleCategory::where('user_id', auth()->user()->id)->get();
        return view('main.org.additional-rates.create')
        ->with([
            'categories' => $categories,
            'type' => AdditionalRate::TYPE_RENTAL
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
            'vehicle_category_id' => 'required|exists:vehicle_categories,id',
        ]); 

        AdditionalRate::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'user_id' => auth()->user()->id,
            'vehicle_category_id' => $request->vehicle_category_id
        ]);

        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully added additional rate.');
    }

    public function edit(Request $request, $additional_rate_id){
        $additional_rate = AdditionalRate::find($additional_rate_id);
        $categories = VehicleCategory::where('user_id', auth()->user()->id)->get();

        return view('main.org.additional-rates.edit')
            ->with([
                'additional_rate' => $additional_rate,
                'categories' => $categories
            ]);
    }

    public function update(Request $request, $additional_rate_id){
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
            'vehicle_category_id' => 'required|exists:vehicle_categories,id',
        ]); 

        AdditionalRate::where('id', $additional_rate_id)
            ->update([
                'name' => $request->name,
                'rate' => $request->rate,
                'vehicle_category_id' => $request->vehicle_category_id
            ]);

        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully updated additional rate.');
    }

    public function delete(Request $request, $additional_rate_id){
        AdditionalRate::where('id', $additional_rate_id)->delete();
        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully deleted additional rate.');
    }
}
