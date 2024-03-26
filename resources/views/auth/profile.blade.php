@extends('layouts.app', ['user' => $user])
@section('content')
    <h2 style="text-align: center">Welcome to profile</h2>

    <div class="container mt-5">

    <form id="terminateAllSessionsForm" action="{{ route('increment') }}" method="POST">
        @csrf
        <div>
            number is :
            <span>{{$increment->number}}</span><br>
        </div>
        <button type="submit" class="btn btn-danger mb-3">Increment</button>
    </form>
    </div>
    <div class="container mt-5">
        <h1 class="mb-4">Active Sessions</h1>

        @if ($activeSessions->isEmpty())
            <p>No active sessions found.</p>
        @else
            <form id="terminateAllSessionsForm" action="{{ route('terminate.all.sessions') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger mb-3">Terminate All Sessions</button>
            </form>

            <ul class="list-group">
                @foreach ($activeSessions as $session)
{{--                    @dd($session);--}}
                    <li class="list-group-item">
{{--                        <h5>Session ID: {{ $session->id }}</h5>--}}
                        <p>Browser: {{ $session->user_agent }}</p>
                        <p>Last Activity: {{ $session->updated_at }}</p>
                        @if($session->session_id == $sessionId)
                            <b style="color: green">This device</b>
                        @endif
                        <form action="{{ route('terminate.session', ['sessionId' => $session->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">Terminate Session</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
@section('sessionExists', $sessionExists)
