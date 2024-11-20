<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    public function store(Request $request) {
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('inquiry_create',([
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required|max:10000',
            ]));
    
            $inquiry = new Inquiry();
            $inquiry->name = $request->name;
            $inquiry->email = $request->email;
            $inquiry->message = $request->message;
            $inquiry->save();
        
            // add mail
            
            return redirect()->route('inquiry.success');
        });
    }
}
