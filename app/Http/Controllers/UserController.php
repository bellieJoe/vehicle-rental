<?php

namespace App\Http\Controllers;

use App\Mail\OrgRegistered;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function app(Request $request) {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.index'); 
        }
        if(Auth::user()->role == 'client') {
            return redirect()->route('client.index'); 
        }
        if(Auth::user()->role == 'org') {
            return redirect()->route('org.index'); 
        }
    }

    public function try(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('app');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
        return view('auth.signin');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function clients(Request $request) {
        $clients = User::where('role', 'client')->paginate(20);
        
        return view('main.admin.clients')
        ->with('clients', $clients);
    }

    public function orgs(Request $request) {
        $orgs = User::where('role', 'org')->with('organisation')->paginate(20);

        return view('main.admin.organizations')
        ->with('orgs', $orgs);
    }


    public function registerClient(Request $req) {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'role' => 'client',
        ]);

        new Registered($user);

        return redirect()->route('app');
    }

    public function verificationNotice(Request $request) {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();
 
        return redirect()->route('app');
    }

    public function sendVerificationEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('message', 'Verification link sent! Please check your email inbox and click on the link to verify your email address.');
    }

    public function registerOrg(Request $request) {
        return DB::transaction(function () use ($request) {
            $request->validateWithBag('org_register', [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
                'address' => 'required',
                'org_name' => 'required',
                'gcash_number' => 'required',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'org',
            ]);
    
            $organisation = Organisation::create([
                'user_id' => $user->id,
                'org_name' => $request->org_name,
                'address' => $request->address,
                'gcash_number' => $request->gcash_number,
            ]);

            Mail::to($user->email)->send(new OrgRegistered($user, $organisation, $request->password));
    
            return redirect()->back()->with('message', 'Organization registered successfully!');
        });
    }
}
