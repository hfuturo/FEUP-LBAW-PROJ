@extends('layouts.app')

@section('head')
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/feed.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/search.js') }} defer></script>
@endsection

@section('content')
    <h2>Advanced search</h2>
    <form id="advanced_search_form">
        <label>Title<input type="text" name="title" placeholder="Title"></label>
        <label>Content<input type="text" name="content" placeholder="Content"></label>
        <button type="submit" class="button">Search</button>
    </form>
    <div class="all_news">
        @include('partials.list_feed', ['news_list' => $news_list, 'perPage' => $perPage])
    </div>
@endsection
