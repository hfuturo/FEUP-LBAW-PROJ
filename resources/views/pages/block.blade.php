@extends('layouts.authentication')

@section('authentication')
    @if (Auth::user()->appeal_rejected)
        <h2>Your account has been banned.</h2>
        <p>Your unban appeal has been rejected.</p>
        <a class="button" href="{{ route('logout') }}">Logout</a>
    @else
        <form method="POST" action="{{ route('appeal') }}">
            @csrf
            <label for="text">Tell us why you should be unbanned.</label>
            <textarea id="text" name="text" placeholder="" rows="6" required>{{ Auth::user()->blocked_appeal }}</textarea>
            <div>
                <button type="submit" class="authentication">Submit</button>
                <a class="button" href="{{ route('logout') }}">Logout</a>
            </div>
        </form>
    @endif
@endsection
