@extends('layouts.app')

@section('head')
@section('head')
    <link href="{{ url('css/profile.css') }}" rel="stylesheet">
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/vote.js') }} defer></script>
@endsection

@section('content')

    <section class="info_section">
        <?php
        $follow_tag = Auth::user()
            ->follow_tags()
            ->where('id_tag', $tag->id)
            ->first();
        ?>
        <h2>{{ $tag->name }} </h2>
        Followers <span id="folowers_tag_count">{{ $tag->followers->count() }}</span>
        <input type="hidden" id="id_tag" name="id_tag" value="{{ $tag->id }}">
        @if ($follow_tag)
            <button id="follow_tag" data-operation="unfollow">Unfollow</button>
        @else
            <button id="follow_tag" data-operation="follow">Follow</button>
        @endif
        @include('partials.list_feed', ['news_list' => $news, 'perPage' => 5])
    </section>


@endsection
