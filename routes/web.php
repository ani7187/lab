<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/email/verify/{token}', [VerificationController::class,'verify'])->name('verification.verify');
Route::get('/email/verify-notice', [VerificationController::class, 'showNotice'])->name('auth.notice');
Route::post('/email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//terminate.session
Route::post('/terminate-session/{sessionId}', [SessionController::class, 'terminate'])->name('terminate.session')->middleware("auth");
Route::post('/terminate-session-all', [SessionController::class, 'terminateAll'])->name('terminate.all.sessions')->middleware("auth");
Route::post('/increment', [SessionController::class, 'increment'])->name('increment')->middleware("auth");

Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware("auth");
