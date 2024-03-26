<?php

namespace App\Http\Middleware;

use Illuminate\Session\SessionManager;
use Closure;

class CustomSessionMiddleware
{
    protected $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function handle($request, Closure $next)
    {
        // Ensure that Laravel's session manager is used for session handling
        $this->sessionManager->start();
//        dd($next($request));

        return $next($request);
    }
}
