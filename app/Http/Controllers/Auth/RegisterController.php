<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{

    public function index(Request $request) {
        $sessionId = $request->cookie('session_id');
        $sessionExists = Session::where('session_id', $sessionId)->exists();

        return view('auth.register', compact('sessionExists'));
    }

    public function store(Request $request)
    {
//        dd($request);
        $rules = [
            'email' => 'required|string|email|max:255|unique:users|regex:/^[^\s@]+@[^\s@]+\.[^\s@]+$/',
            'password' => 'required|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{11,}$/',
            'tel' => 'required|string|unique:users|regex:/^\+374\d{8}$/',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
//            dd("fail");
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'is_active' => 0,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'email_verification_token' => Str::random(40),
        ]);

        Mail::to($user->email)->send(new \App\Mail\VerifyEmail($user));

        return redirect()->route('auth.notice');

//        return redirect()->route('register')->with('success', 'Registration successful!');
    }
}
