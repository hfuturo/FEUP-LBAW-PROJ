@extends('layouts.app')

@section('head')
    <link href="{{ url('css/moderator.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/moderator.js') }} defer></script>
@endsection

@section('content')
    <section id="topics">
        @foreach ($topics as $topic)
            <article class="topic" id-topic="{{ $topic->id }}">
                <div>
                    <h3><a href="{{ route('topic', ['topic' => $topic]) }}">{{ $topic->name }}</a></h3>
                    <span class="nMods" value="{{ $topic->moderators->count() }}">({{ $topic->moderators->count() }})</span>
                    <button onclick="openMakeModeratorUser(this)"><i class="fa-solid fa-plus"></i></button>
                </div>
                <ul>
                    @if ($topic->moderators->count() === 0)
                        <li>This topic has no moderators</li>
                    @else
                        @foreach ($topic->moderators as $moderator)
                            <li class="moderator" id="{{ $moderator->id }}">
                                <a href="{{ route('profile', ['user' => $moderator]) }}">{{ $moderator->name }}</a>
                                <button onclick="revokeModerator2(this)" class="button">Revoke privileges</button>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </article>
        @endforeach
    </section>
    <div id="list_users_popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeMakeModeratorUser()">&times;</span>
            <form id="choose_user_form">
                @csrf
                <input type="hidden" name="id_topic" id="id_topic" value="">
                <label>Select an user to moderator</label>
                <select id="select_user">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <button type="submit">Make</button>
            </form>
        </div>
    </div>
@endsection
