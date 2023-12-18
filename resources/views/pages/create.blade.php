@extends('layouts.app')

@section('head')
    <link href="{{ url('css/create_news.css') }}" rel="stylesheet">
    <link href="{{ url('css/tags.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
@endsection

@section('content')
    <section id = "news-create-container">
        <h2> Create a Post</h2>
        <form action="{{ route('create_news_api') }}" method = "POST" id="newsForm" enctype="multipart/form-data">
            @csrf

            <div class ="form-group">
                <input maxlength="255" type="text" id="title" name="title" placeholder="Title">
            </div>

            <div class ="form-group">
                <textarea id="text" name="text" placeholder="Write something" rows="6"></textarea>
            </div>

            <div class ="form-group">
                <label for='image' class=custom-file-upload>Add image</label>
                <input type="file" id="image" name="image">
            </div>

            <div class ="form-group">
                <label for='topics'>Choose the topic</label>
                <select id="topic" name="topic">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class ="form-group">
                <label for='organizations'>Choose related organization</label>
                <select id="organization" name="organization">
                    <option value="NULL">No organization</option>
                    @foreach ($organizations as $org)
                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class ="form-group">
                <label>Tags</label>
                <datalist id="tags">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                    @endforeach
                </datalist>
                <div class="tag-container">
                    <input type="text" id="tagInput" name="tags" list="tags" placeholder="Tag" />
                </div>
            </div>
            <button type="submit" form="newsForm" value="Submit">Create</button>
        </form>
    </section>
@endsection
