<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function app(Request $request) {
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.index'); 
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
            if(Auth::user()->role == 'admin') {
                return redirect()->intended('admin');
            }
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
            $orgs = User::where('role', 'org')->paginate(20);

            // return response($orgs);
            return view('main.admin.organizations')
            ->with('orgs', $orgs);
    }
}
