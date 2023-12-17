<?php
use App\Models\Topic;
?>
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
        <label>Author<input type="text" name="author" placeholder="Author"></label>
        <label>Topic<select name="topic" placeholder="Select a topic">
                <option value="" style="color: #767676;" selected>Select a topic</option>
                @foreach (Topic::all() as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                @endforeach
            </select></label>
        <label>Search Anywhere <span
                title="Search for the text anywhere on the News item specificaly in the title, content, author and topic"
                class="hint">?</span><input type="text" name="exact_match"
                placeholder="Search Anywhere in the News item"></label>
        <button type="submit" class="button">Search</button>
    </form>
    <div class="all_news">
        @include('partials.list_feed', ['news_list' => $news_list, 'perPage' => $perPage])
    </div>
@endsection
