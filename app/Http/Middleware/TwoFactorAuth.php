<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuth
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->google2fa_enabled && !$request->session()->has('2fa_passed')) {
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
