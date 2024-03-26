<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller {
    public function verify($token)
    {
        $user = User::where('email_verification_token', $token)->firstOrFail();

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            return redirect()->route('login')->with('success', 'Registration successful!');
        } else {
            return redirect()->route('register')->with('error', 'Registration failed!');
        }
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Your email is already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resent', true);
    }

    public function showNotice(Request $request)
    {
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Your email is already verified.');
        }
        return view('auth.notice');
    }

}
