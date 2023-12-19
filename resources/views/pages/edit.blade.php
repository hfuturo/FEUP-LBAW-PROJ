@extends('layouts.app')

@section('head')
    <link href="{{ url('css/create_news.css') }}" rel="stylesheet">
    <link href="{{ url('css/tags.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/tags.js') }} defer></script>
@endsection

@section('content')
    <section id = "news-create-container">
        <h2> Edit Post</h2>
        <form action="{{ route('edit_news_api', ['id' => $news_item->id]) }}" method = "POST" id="newsForm"
            enctype="multipart/form-data">
            @csrf

            <div class ="form-group">
                <input maxlength="255" type="text" id="title" name="title" placeholder="Title" value="{{ $news_item->title }}">
            </div>

            <div class ="form-group">
                <textarea id="text" name="text" placeholder="Write something" rows="6">{{ $news_item->content->content }}</textarea>
            </div>

            <div class ="form-group">
                <label for='image'>Add image</label>
                <input type="file" id="image" name="image" value="{{ $news_item->image }}">
            </div>

            <div class ="form-group">
                <label for='topics'>Choose the topic</label>
                <select id="topic" name="topic">
                    @foreach ($topics as $topic)
                        @if ($topic->id === $news_item->topic->id)
                            <option value="{{ $topic->id }}" selected>{{ $topic->name }}</option>
                        @else
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class ="form-group">
                <label for='organizations'>Choose related organization</label>
                <select id="organization" name="organization">
                    @foreach ($organizations as $organization)
                        <option value="">No organization</option>
                        @if ($organization->id === $news_item->content->organization->id)
                            <option value="{{ $organization->id }}" selected>{{ $organization->name }}</option>
                        @else
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>


            <div class ="form-group">
                <label>Add tags</label>
                <datalist id="tags">
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                    @endforeach
                </datalist>
                <div class="tag-container">
                    <input type="text" id="tagInput" name="tags" list="tags" placeholder="Tag"
                        value="{{ implode(' ', array_map(fn($a) => $a['name'], $news_item->tags->toArray())) }}" />
                </div>
            </div>
            <span id="edit_or_cancel_edition_news">
                <button type="submit" form="newsForm" value="Submit">Edit</button>
                <a href={{ route('news_page', ['id' => $news_item->id]) }} class="button">Cancel</a>
            </span>
        </form>
    </section>
@endsection
