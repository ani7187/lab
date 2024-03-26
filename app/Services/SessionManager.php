<?php
// app/Services/SessionManager.php

namespace App\Services;

class SessionManager
{
    public function startSession()
    {
        if (!session_id()) {
            session_start();
        }
    }

    public function set($key, $value)
    {
        $this->startSession();
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        $this->startSession();
        return $_SESSION[$key] ?? null;
    }

    public function forget($key)
    {
        $this->startSession();
        unset($_SESSION[$key]);
    }

    public function destroy()
    {
        $this->startSession();
        session_destroy();
    }
}
