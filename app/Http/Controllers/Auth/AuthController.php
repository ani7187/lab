<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Services\SessionManager;
use App\Models\FailedLoginAttempt;
use App\Models\Increment;
use App\Models\Session;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function showLoginForm(Request $request)
    {
        $sessionId = $request->cookie('session_id');
        $sessionExists = Session::where('session_id', $sessionId)->exists();
        $user = [];
        $error = "";
        $email = "";
        return view('auth.login', compact('sessionExists', 'user', 'error', 'email'));
    }

    public function login(Request $request)
    {
        $error = "Invalid login credentials";
        $sessionId = $request->cookie('session_id');
        $sessionExists = Session::where('session_id', $sessionId)->exists();
        $user = [];
        $email = $request->input('email');

        $uniqueStr = $request->input('email');
        $uniqueStr .= $request->ip();
        $uniqueStr .= $request->userAgent();
        $uniqueStr .= $request->header('sec-ch-ua-platform');
//        $uniqueStr .= $request->header('sec-ch-ua');

        $uniqueStr = md5($uniqueStr);

        // Validate the request data (username and password)
        $credentials = $request->only('email', 'password');

        if ($this->hasExceededLoginAttempts($request->input('email'), $uniqueStr)) {
            $this->incrementLoginAttempts($email, $uniqueStr);
            $error = "Too many attempts, try leter";
            return view('auth.login', compact("error", "sessionExists", "user", 'email'));
        }


        if (auth()->attempt($credentials)) {

            $sessionId = uniqid();
            $user = User::where('email', $request->email)->first();
            $userAgent = $request->userAgent();

            $session = new Session();
            $session->user_id = $user->id;
            $session->user_agent = $userAgent;
            $session->session_id = $sessionId;
            $session->save();

            $this->clearLoginAttempts($request->input('email'), $uniqueStr);
            return redirect()->intended('/profile')->cookie('session_id', $sessionId);
        }

        $this->handleFailedLogin($request->input('email'), $uniqueStr);

        return view('auth.login', compact("error", "sessionExists", "user", 'email'));
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $sessionId = $request->cookie('session_id');
        $session = Session::where('session_id', $sessionId)->first();

        if ($session) {
            $session->delete();
        }

        return redirect('/login');
    }

    public function profile(Request $request) {

        $sessionId = $request->cookie('session_id');
        $sessionExists = Session::where('session_id', $sessionId)->exists();

        $session = Session::where('session_id', $sessionId)->first();
        $user = User::find($session['user_id']);

        $increment = Increment::find(1);
        $activeSessions = Session::where('user_id', $user->id)->get();
        return view('auth.profile', compact("sessionExists", 'user', 'activeSessions', 'sessionId', 'increment'));
    }

    private function handleFailedLogin($email, $uniqueStr)
    {
        $this->incrementLoginAttempts($email, $uniqueStr);
    }

    private function incrementLoginAttempts($email, $identifier)
    {
        $loginAttempt = FailedLoginAttempt::where('email', $email)
            ->where('identifier', '=', $identifier)
            ->where('login_attempt_time', '>=', Carbon::now()->subMinutes(10))
            ->first();

        if ($loginAttempt) {
            $loginAttempt->increment('login_attempts_count');
            $loginAttempt->login_attempt_time = Carbon::now();
            $loginAttempt->update();
        } else {
            FailedLoginAttempt::create([
                'email' => $email,
                'identifier' => $identifier,
                'login_attempt_time' => Carbon::now(),
                'login_attempts_count' => 1,
            ]);
        }
    }

    private function hasExceededLoginAttempts($email, $identifier)
    {
        $loginAttempt = FailedLoginAttempt::where('email', $email)
            ->where('identifier', '=', $identifier)
            ->where('login_attempt_time', '>=', Carbon::now()->subMinutes(10))
            ->first();

        return $loginAttempt && $loginAttempt->login_attempts_count >= 3;
    }

    private function clearLoginAttempts($email, $identifier)
    {
        FailedLoginAttempt::where('email', $email)
            ->where('identifier', '=', $identifier)
            ->delete();
    }
}
