@extends('layouts.authentication')

@section('authentication')
    @if (Auth::user()->appeal_rejected)
        <div class="banned_wrapper">
            <h2>Your account has been banned.</h2>
            <p>Your unban appeal has been rejected.</p>
            <div class="button_wrapper_banned">
                <a class="button banned_logout" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    @else
        <h2>Your account has been blocked.</h2>
        <form method="POST" action="{{ route('appeal') }}">
            @csrf
            <label for="text">Tell us why you should be unbanned.</label>
            <textarea id="text" name="text" placeholder="" rows="6" required>{{ Auth::user()->blocked_appeal }}</textarea>
            <div class="button_wrapper">
                <button type="submit" class="authentication">Submit</button>
                <a class="button" href="{{ route('logout') }}">Logout</a>
            </div>
        </form>
    @endif
@endsection
