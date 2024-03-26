<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Auth
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    /*protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }*/

    public function handle($request, Closure $next)
    {
        $sessionId = $request->cookie('session_id');
        $session = Session::where('session_id', $sessionId)->first();
        if (empty($session)) {
            return redirect('/login');
        }
        return $next($request);
    }
}
