@extends('layouts.authentication')

@section('authentication')
<h2> Login </h2>
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" placeholder="Password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label id="remember">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit" class="authentication">
        Login
    </button>

    <div class="authentication_auth_links">
        <p class="authentication">Don't Have an account?<a href="{{ route('register') }}">Sign Up</a></p>
        <a href=" {{ route('recover_password') }}" class="authentication">Forgot my password</a>
    </div>

    @include('partials.error_message')
</form>

@endsection