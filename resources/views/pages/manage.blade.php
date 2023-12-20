@extends('layouts.app')

@section('head')
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/moderator.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/manage.js') }} defer></script>
@endsection

@section('content')
    <section id="users">
        <h2>List of Users</h2>
        <input id="filter_users" name="filter_users" placeholder="User's name">
        <nav id="all_users">
            @each('partials.manage', $users, 'user')
        </nav>
    </section>
    <div id="topic_list_popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeMakeModeratorTopic()">&times;</span>
            <form id="choose_topic_form">
                @csrf
                <input type="hidden" name="id_user" id="id_user" value="">
                <label>What topic will moderate?</label>
                <select id="select_topic">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Make</button>
            </form>
        </div>
    </div>
@endsection
