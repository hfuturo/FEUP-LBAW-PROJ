@extends('layouts.app')

@section('head')
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/feed.js') }} defer></script>
@endsection

@section('content')
    <h2>All the news in one place...</h2>
    <div class="feed_buttons scrool-target">
        <a class="button feed_button" href="{{ route('news') }}">Top Feed</a>
        @if (Auth::check())
            <a class="button feed_button" href="{{ route('follow_feed') }}">Following Feed</a>
        @endif
        <a class="button feed_button" href="{{ route('recent_feed') }}">Recent Feed</a>
    </div>
    <div class="all_news">
        @include('partials.list_feed', ['news_list' => $news_list, 'perPage' => $perPage])
    </div>
@endsection
