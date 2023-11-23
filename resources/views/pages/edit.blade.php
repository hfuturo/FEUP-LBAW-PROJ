@extends('layouts.app')

@section('content')

<section id = "news-create-container">
    <h2> Edit Post</h2>
    @include('partials.error_message')
    <form action="{{ route('edit_news_api', ['id' => $news_item->id]) }}" method = "POST" id="newsForm" enctype="multipart/form-data">
        @csrf

        <div class ="form-group">
            <textarea maxlength="255" type="text" id="title" name="title" placeholder="Title" rows="1">{{$news_item->title}}</textarea>
        </div>

        <div class ="form-group">
            <textarea id="text" name="text" placeholder="Write something" rows="6">{{$news_item->content->content}}</textarea>
        </div>

        <div class ="form-group">
            <label for='image'>Add image</label>
            <input type="file" id="image" name="image" value="{{$news_item->image}}">
        </div>

        <div class ="form-group">
            <label for='topics'>Choose the topic</label>
            <select id="topic" name="topic">
                @foreach($topics as $topic)
                    @if($topic->id === $news_item->topic->id)
                        <option value="{{$topic->id}}" selected>{{$topic->name}}</option>  
                    @else
                    <option value="{{$topic->id}}">{{$topic->name}}</option> 
                    @endif
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
            <button type="button" onclick="createTag()" class= "btn">Add</button>
            <ul id="tagsList">
                @foreach($news_item->tags as $newsTag)
                    <li><span class="tagText" id="{{$newsTag->name}}">{{$newsTag->name}}</span><span class="remove" onclick = "removeTag(this.parentElement)">X</span></li>
                @endforeach
            </ul>
        </div>
        <button type="submit" form="newsForm" value="Submit" class = "button">Edit</button>
        <a href={{ route('news_page', ['id' => $news_item->id]) }}  class="button" style="display:inline-block;">Cancel</a>
    </form>
</section>

@endsection