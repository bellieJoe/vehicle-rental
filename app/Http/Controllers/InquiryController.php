<?php

namespace App\Http\Controllers;

use App\Mail\SendInquiry;
use App\Models\Inquiry;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
            
            return redirect()->back();
        });
    }

    public function reply(Request $request) {
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('inquiry_reply',([
                'message' => 'required|max:10000',
                'inquiry_id' => 'required|exists:inquiries,id',
            ]));
    
            $inquiry = Inquiry::find($request->inquiry_id);
            
            $reply = Reply::create([
                'inquiry_id' => $inquiry->id,
                'message' => $request->message,
                'email' => $inquiry->email
            ]);
            
            Mail::to($inquiry->email)->send(new SendInquiry($inquiry->name, $reply->message, "Inquiry Reply"));
            
            return redirect()->back()->with('message', 'Reply sent successfully!');
        });
    }

    public function index(Request $request) {
        $inquiries = Inquiry::query()
        ->withCount('replies')
        ->with([
            'replies'
        ])
            ->paginate((10));

        return view('main.admin.inquiries.index')
            ->with('inquiries', $inquiries);
    }
}
