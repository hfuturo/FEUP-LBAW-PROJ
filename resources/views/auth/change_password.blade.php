@extends('layouts.authentication')

@section('authentication')

@if ($errors->any())
    <p class="error">{{ $errors->first() }}</p>
@endif

<h2> Change Password </h2>
<form method="POST" action={{ route('change_password') }}>
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" placeholder="Email" value={{ $email }} required readonly>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" placeholder="Password" required>
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Password" required>
    <button class="authentication" type="submit">Change password</button>
    <div class="authentication_auth_links">
        <p class="authentication">Already have an account?<a href="{{ route('login') }}">Sign In</a></p>
        <p class="authentication">Don't Have an account?<a href="{{ route('register') }}">Sign Up</a></p>
    </div>
</form>
@endsection

