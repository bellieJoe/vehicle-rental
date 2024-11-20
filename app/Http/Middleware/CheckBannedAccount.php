<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBannedAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->is_banned) {
            return redirect()->route('auth.account-banned');
        }
        return $next($request);
    }
}
