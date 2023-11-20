@extends('layouts.app')


@section('content')

<section id = "news">
    @include('partials.error_message')
    @if (Auth::check() && (Auth::user()->id === $news_item->content->authenticated_user->id))
        <form action="{{ route('destroy', ['id' => $news_item->id]) }}" method="post">
            @csrf
            <button type="submit">Delete</button>
        </form>
    @endif
    <article class = "news_body">
        <div class = "news_head">
            <a href="" class="topic">{{$news_item->topic->name}}</a>
            <h2 class = "title" >{{$news_item->title}}</h2>
            <span>Posted by</span>
            <a href="{{ route('profile', ['user' => $news_item->content->authenticated_user]) }}" class = "author">{{$news_item->content->authenticated_user->name}}</a>
            @if ($news_item->content->organization !== NULL)
                <span>Associated with</span>
                <a href="" class = "org"> {{$news_item->content->organization->name}}</a>
            @endif
        </div>
        @if($news_item->image !== NULL)
            <img src="/img/news_image/{{$news_item->image}}" alt="{{$news_item->title}}" >
        @endif
        <p class = "news_text">{{$news_item->content->content}}</p>
        <p  class = "date" >{{$news_item->content->date}}</p>
        <div class = tags>
            @foreach ($news_item->tags as $tag)
                <a href="" class="tag">{{$tag->name}}</a>
            @endforeach
        </div>
        <div class="votes">
            <a href="" class="like">Like </a>
            <a href="" class="like">Dislike</a>
        </div>
    </article>
</section>
<section id = "comments">
    @if ($comments->count() === 0)
        <p class="not_comments"> There are no comments yet</p>
    @else
        @foreach ($comments as $comment)
            <article class="comment">
                <div class="comment_header">
                    <a href="" class="comment_author"> {{$comment->content->authenticated_user->name}}</a>
                    <p class=date> {{$comment->content->date}}</p>
                    @if ($comment->content->edit_date !== NULL)
                    <p class=date> {{$comment->content->edit_date}}</p>
                    @endif
                </div>
                <p class="comment_text">{{$comment->content->content}}</p>
                <div class="votes">
                    <a href="" class="like">Like </a>
                    <a href="" class="like">Dislike</a>
                </div>
            </article>
        @endforeach
        <div id="pag">
           {{$comments->links()}} 
        </div>
    @endif
</section>

@endsection