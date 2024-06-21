<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorAuthController extends Controller
{
    public function show2faForm(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $google2fa = app('pragmarx.google2fa');

        if (is_null($user->google2fa_secret)) {
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = $secret;
            $user->save();
        } else {
            $secret = $user->google2fa_secret;
        }

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('2fa.setup', ['QR_Image' => $QR_Image, 'secret' => $secret]);
    }

    public function enable2fa(Request $request)
    {
        $request->validate([
            'verify-code' => 'required|digits:6',
        ]);

        $user = User::find(Auth::user()->id);
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('verify-code'));

        if ($valid) {
            $user->google2fa_enabled = true;
            $user->save();

            return redirect()->route('home')->with('success', '2FA is enabled successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid verification code, please try again.');
        }
    }

    public function verify2faForm()
    {
        return view('2fa.verify');
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'verify-code' => 'required|digits:6',
        ]);

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->input('verify-code'));

        if ($valid) {
            $request->session()->put('2fa_passed', true);

            return redirect()->route('home')->with('success', '2FA verification successful.');
        } else {
            return redirect()->back()->with('error', 'Invalid verification code, please try again.');
        }
    }
}
