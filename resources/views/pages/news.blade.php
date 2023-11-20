@extends('layouts.app')

@section('content')

@include('partials.error_message')
<div class="feed_buttons">
    <a class="button feed_button" href="{{ route('top_feed') }}">Top Feed</a>
    @if (Auth::check())
    <a class="button feed_button" href="{{ route('follow_feed') }}">Following Feed</a>
    @endif
    <a class="button feed_button" href="{{ route('recent_feed') }}">Recent Feed</a>
</div>
<div class="all_news">
    @include('partials.list_feed', ['news_list' => $news_list, 'perPage' => $perPage])
</div>

@endsection