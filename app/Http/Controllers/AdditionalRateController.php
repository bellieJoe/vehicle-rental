<?php

namespace App\Http\Controllers;

use App\Models\AdditionalRate;
use Illuminate\Http\Request;

class AdditionalRateController extends Controller
{
    //
    public function index(Request $request) {

        $additional_rates = AdditionalRate::where('user_id', auth()->user()->id)->get();

        return view('main.org.additional-rates.index')
            ->with('additional_rates', $additional_rates);
    }

    public function create(){
        return view('main.org.additional-rates.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
        ]); 

        AdditionalRate::create([
            'name' => $request->name,
            'rate' => $request->rate,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully added additional rate.');
    }

    public function edit(Request $request, $additional_rate_id){
        $additional_rate = AdditionalRate::find($additional_rate_id);

        return view('main.org.additional-rates.edit')
            ->with('additional_rate', $additional_rate);
    }

    public function update(Request $request, $additional_rate_id){
        $request->validate([
            'name' => 'required',
            'rate' => 'required',
        ]); 

        AdditionalRate::where('id', $additional_rate_id)
            ->update([
                'name' => $request->name,
                'rate' => $request->rate,
            ]);

        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully updated additional rate.');
    }

    public function delete(Request $request, $additional_rate_id){
        AdditionalRate::where('id', $additional_rate_id)->delete();
        return redirect()->route('org.additional-rates.index')->with('success', 'Successfully deleted additional rate.');
    }
}
