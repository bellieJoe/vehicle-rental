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
            return redirect()->route('client.vehicles'); 
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
                'stripe_secret_key' => 'required'
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
                'stripe_secret_key' => $request->stripe_secret_key
            ]);

            Mail::to($user->email)->send(new OrgRegistered($user, $organisation, $request->password));
    
            return redirect()->back()->with('message', 'Organization registered successfully!');
        });
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = time().'.'.$request->profile_picture->extension();
        $request->profile_picture->move(public_path('images/profile'), $imageName);

        $user = User::find(auth()->user()->id);
        $user->profile_picture = $imageName;
        $user->save();

        return redirect()->back()->with('message', 'Profile picture updated successfully!');
    }

    public function updatePassword(Request $request) {
        $request->validateWithBag('reset_passsword', [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        $user = User::find(auth()->user()->id);
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->back()->with('message', 'Password updated successfully!');
        } else {
            return redirect()->back()->with('message', 'Old password is incorrect!');
        }
    }

    public function banAccount(Request $request) {

        $user = User::find($request->user_id);

        $user->update([
            'is_banned' => 1
        ]); 

        return redirect()->back()->with('message', 'Account banned successfully!');
    }


    public function unbanAccount(Request $request) {

        $user = User::find($request->user_id);

        $user->update([
            'is_banned' => 0
        ]); 

        return redirect()->back()->with('message', 'Account unbanned successfully!');
    }
}
