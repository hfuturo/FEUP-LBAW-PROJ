<?php
use App\Models\Topic;
use App\Models\Tag;
?>
@extends('layouts.app')

@section('head')
    <link href="{{ url('css/feed.css') }}" rel="stylesheet">
    <link href="{{ url('css/tags.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/feed.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/search.js') }} defer></script>
    <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
@endsection

@section('content')
    <h2>Advanced search</h2>
    <form id="advanced_search_form">
        <label>Title<input class="form-item" type="text" name="title" placeholder="Title"
                value="{{ app('request')->input('title') }}"></label>
        <label>Content<input class="form-item" type="text" name="content" placeholder="Content"
                value="{{ app('request')->input('content') }}"></label>
        <label>Author<input class="form-item" type="text" name="author" placeholder="Author"
                value="{{ app('request')->input('author') }}"></label>
        <label>Topic<select class="form-item" name="topic" placeholder="Select a topic">
                <option value="" style="color: #767676;">Select a topic</option>
                @foreach (Topic::all() as $topic)
                    <option value="{{ $topic->id }}"
                        {{ $topic->id == app('request')->input('topic') ? 'selected' : '' }}>
                        {{ $topic->name }}</option>
                @endforeach
            </select></label>
        <label>Tags <span title="To insert a tag press space or enter and to remove click them" class="hint">?</span>
            <datalist id="tags">
                @foreach (Tag::all() as $tag)
                    <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                @endforeach
            </datalist>
            <div class="tag-container">
                <input type="text" id="tagInput" name="tags" list="tags" placeholder="Tag"
                    value="{{ app('request')->input('tags') }}" />
            </div>
        </label>
        <label>After: <input class="form-item" type="date" name="after"
                value="{{ app('request')->input('after') }}"></label>
        <label>Before: <input class="form-item" type="date" name="before"
                value="{{ app('request')->input('before') }}"></label>
        <label for="exact">Search anywhere <input class="form-item" type="text" name="fulltext"
                placeholder="Search Anywhere in the News item" value="{{ app('request')->input('fulltext') }}"></label>
        <label>Search anywhere for exact text <span
                title="Search for the text anywhere on the news item exactly (separated from the rest by spaces)"
                class="hint">?</span><input class="form-item" type="text" name="exact_match"
                placeholder="Search Anywhere in the News item" value="{{ app('request')->input('exact_match') }}"></label>
        <fieldset>
            <legend>Order by:</legend>
            <div class="form-item">
                <input id="ord_new" type="radio" name="order" value="new" required
                    {{ !app('request')->has('order') || app('request')->input('order') == 'new' ? 'checked' : '' }}>
                <label for="ord_new">Newest</label>
                <input id="ord_old" type="radio" name="order" value="old" required
                    {{ app('request')->input('order') == 'old' ? 'checked' : '' }}>
                <label for="ord_old">Oldest</label>
                <input id="ord_popular" type="radio" name="order" value="popular" required
                    {{ app('request')->input('order') == 'popular' ? 'checked' : '' }}>
                <label for="ord_popular">Popular</label>
            </div>
        </fieldset>
        <button type="submit" class="button">Search</button>
    </form>
    <div class="all_news scrool-target">
        @include('partials.list_feed', ['news_list' => $news_list, 'perPage' => $perPage])
    </div>
@endsection
