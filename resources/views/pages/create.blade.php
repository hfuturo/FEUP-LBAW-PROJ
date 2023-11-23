
@extends('layouts.app')

@section('content')

<section id = "news-create-container">
    <h2> Create a Post</h2>
    @include('partials.error_message')
    <form action="{{ route('create_news_api') }}" method = "POST" id="newsForm" enctype="multipart/form-data">
        @csrf

        <div class ="form-group">
            <textarea maxlength="255" type="text" id="title" name="title" placeholder="Title" rows="1"></textarea>
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
                @foreach($topics as $topic)
                    <option value="{{$topic->id}}">{{$topic->name}}</option>
                @endforeach
            </select>
        </div>

        <div class ="form-group">
            <label>Add tags</label>
            <datalist id="tags">
                @foreach($tags as $tag)
                    <option value="{{$tag->name}}">{{$tag->name}}</option>
                @endforeach
            </datalist>
            <input type="text" id="tagInput" list="tags" placeholder="Tag" pattern="\S.*\S?" title="This field most not be empty" />
            <button type="button" onclick="createTag()" class= "button">Add</button>
            <ul id="tagsList"></ul>
        </div>
        <button type="submit" form="newsForm" value="Submit" class = "button">Create</button>
    </form>
</section>

@endsection

