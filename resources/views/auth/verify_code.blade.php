@extends('layouts.authentication')

@section('authentication')

@if ($errors->any())
    <p class="error">{{ $errors->first() }}</p>
@endif

@if (session()->has('success'))
    <p class="success"> {{ session()->get('success') }}</p>
@endif

<h2> Recover Password </h2>
<form method="POST" action={{ route('verify_code') }}>
    @csrf
    <label for="email">Email</label>
    <input id="email" type="email" name="email" placeholder="Email" value={{ $email }} required readonly>
    <label for="code">Code</label>
    <input id="code" type="text" name="code" placeholder="Code" required>
    <button class="authentication" type="submit">Verify code</button>
    <div class="authentication_auth_links">
        <p class="authentication">Already have an account?<a href="{{ route('login') }}">Sign In</a></p>
        <p class="authentication">Don't Have an account?<a href="{{ route('register') }}">Sign Up</a></p>
    </div>
</form>
@endsection

