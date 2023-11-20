@extends('layouts.app')

@section('content')

<div class="feed_buttons">
    @include('partials.error_message')
    @if (Auth::check())
    <button class="feed_button follow_feed">Following Feed</button>
    @endif
    <button class="feed_button recent_feed">Recent Feed</button>
</div>
<div class="all_news">
    <span class="paginate"></span>
</div>

@endsection