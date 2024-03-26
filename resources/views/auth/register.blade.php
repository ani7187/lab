@extends('layouts.app')
@section('content')
    @include('partials.alerts')
    <div class="container">
        <div class="row">
            <form method="POST" id="registrationForm" action="{{ route('register') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="{{old('email')}}" required>
                    <span id="emailError" style="color: red;"></span> <!-- Error message container -->
{{--                    @error('email')--}}
{{--                    <span class="text-danger">{{ $message }}</span>--}}
{{--                    @enderror--}}
                </div>
                <div class="col-md-6">
                    <label for="telefon" class="form-label">Telephone</label>
                    <input type="text" name="tel" class="form-control" id="telefon" placeholder="+374XXXXXXXX" value="{{old('telefon')}}">
                    <span id="telefon-error" class="text-danger"></span>
{{--                    @error('tel')--}}
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
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm your password" required>
                    <span id="message"></span><br>
                </div>
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <button type="button" class="btn btn-success" id="generate-password">Generate Password</button>
                    <span id="generated-password"></span>
                </div>
            </form>

        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{ asset('js/auth/register.js') }}"></script>

@endsection
{{--@section('sessionExists', $sessionExists)--}}
