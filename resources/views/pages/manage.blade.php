@extends('layouts.app')

@section('content')

<section id="users">
    <input id="filter_users" name="filter_users" placeholder="User's name"></input>
    <nav id="all_users">
        @each('partials.manage',$users,'user')
    </nav>
</section>

@endsection