@extends('layouts.app')

@section('head')
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/manage.js') }} defer></script>
@endsection

@section('content')
    <section id="users">
        <input id="filter_users" name="filter_users" placeholder="User's name"></input>
        <nav id="all_users">
            @each('partials.manage', $users, 'user')
        </nav>
    </section>
@endsection
