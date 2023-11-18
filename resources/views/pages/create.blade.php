
@extends('layouts.app')

@section('content')

<div id = "news-create-container">
    </h1> Create a news</h1>
    <form action="{{ route('create_news_api') }}" method = "POST" enctype="multipart/form-data">
        @csrf
        <div class ="form-group">
            <input type="text" id="title" name="title" placeholder="Title">
        </div>
        <div class ="form-group">
            <textarea id="text" name="text" placeholder="Text"></textarea>
        </div>
        <div class ="form-group">
            <label for= 'image'>Add image</label>
            <input type="file" id="image" name="image">
        </div>
        <div class ="form-group">
            <select id="topic" name="topic">
                @foreach($topics as $topic)
                    <option value="{{ $topic->id}}">{{$topic->name}}</option>
                @endforeach
            </select>
        </div>
        <input type = "submit" class = "btn">
    </form>
</div>

@endsection