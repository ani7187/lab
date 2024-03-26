<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Increment;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller {

    public function terminate(Request $request, $sessionId)
    {
        $session = Session::where('id', $sessionId)->first();
        $cookieSessionId = $request->cookie('session_id');

        if ($cookieSessionId == $session->session_id) {
            $session->delete();
            return redirect('/login');
        } else {
            $session->delete();
            return redirect('/profile');
        }
    }

    public function terminateAll(Request $request)
    {
        $cookieSessionId = $request->cookie('session_id');
        $session = Session::where('session_id', $cookieSessionId)->first();
        $user = User::find($session['user_id']);

        Session::where('user_id', $user->id)->delete();

        return redirect('/login');
    }

    public function increment(Request $request) {
        $increment = Increment::find(1);
        $increment->number++;
        $increment->save();

        return redirect('/profile');

    }
}
