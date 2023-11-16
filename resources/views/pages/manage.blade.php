@extends('layouts.manage')

@section('content')

<section id="users">
    <input list="list_users" id="filter_users" name="filter_users" placeholder="User's name"></input>
    <nav id="all_users">
        @each('partials.manage',$users,'user')
    </nav>
</section>

@endsection