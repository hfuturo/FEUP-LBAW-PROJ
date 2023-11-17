@extends('layouts.app')

@section('content')

<section id = "feed">
    <article class = "news">
        <div class = "news_head">
        <span class = "author"> Public by {{$news_item->content->authenticated_user->name}}</span>
        @if ($news_item->content->organization !== NULL)
        <span class = "org"> {{$news_item->content->organization->name}}</span>
        @endif
        </div>
        <h2 class = "title" >{{$news_item->title}}</h2>
        <p class = "news_text">{{$news_item->content->content}}</p>
        <p  class = "date" >{{$news_item->content->date}}</p>
        <p></p>
    </article>

</section>

@endsection