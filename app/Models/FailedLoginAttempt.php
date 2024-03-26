<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedLoginAttempt extends Model
{
    protected $table = "login_attempts";
    protected $fillable = ['identifier', 'email', 'login_attempt_time', 'login_attempts_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
