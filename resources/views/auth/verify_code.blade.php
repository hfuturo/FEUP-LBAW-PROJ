@extends('layouts.authentication')

@section('authentication')

@include('partials.error_message')

<h2> Recover Password </h2>

<form method="POST" action={{ route('verify_code') }}>
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" placeholder="Email" value="{{ $user->email }}" required readonly>
    <label for="code">Code</label>
    <input id="code" type="text" name="code" placeholder="Code" value="{{ old('code') ? old('code') : ''}}" required>
    @error("code")
        <p class="input_error">{{ $message }}</p>
    @enderror
    <label for="password">New Password</label>
    <input id="password" type="password" name="password" placeholder="Password" required>
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Password" required>
    @error("password") 
        <p class="input_error">{{ $message }}</p> 
    @enderror
    <label id="remember">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <p>Remember Me</p>
    </label>
    <button class="authentication" type="submit">Login</button>
    <div class="authentication_auth_links">
        <p class="authentication">Already have an account?<a href="{{ route('login') }}">Sign In</a></p>
        <p class="authentication">Don't Have an account?<a href="{{ route('register') }}">Sign Up</a></p>
    </div>
</form>
@endsection

