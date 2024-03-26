@extends('layouts.app', ['user', $user])
@section('content')
    @include('partials.alerts')
    <div class="container">
        <div class="row">
            <form method="POST" id="registrationForm" action="{{ route('login.submit') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{$email}}" required>
                    <span id="emailError" style="color: red;"></span> <!-- Error message container -->
                    @if($error)
                        <span class="text-danger">{{ $error }}</span>
                    @endif
{{--                    @error('email')--}}
{{--                    <span class="text-danger">{{ $message }}</span>--}}
{{--                    @enderror--}}
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    <span id="password-error" class="text-danger"></span>
                    <span id="password-strength"></span>
{{--                    @error('password')--}}
{{--                    <span class="text-danger">{{ $message }}</span>--}}
{{--                    @enderror--}}
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@section('sessionExists', $sessionExists)

