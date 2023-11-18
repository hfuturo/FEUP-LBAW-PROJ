@extends('layouts.app')


@section('content')

<section id = "news">
    <article class = "news_body">
        <div class = "news_head">
            <a href="" class="topic">{{$news_item->topic->name}}</a>
            <h2 class = "title" >{{$news_item->title}}</h2>
            </div>
                <span>Posted by</span>
                <a href="" class = "author">{{$news_item->content->authenticated_user->name}}</a>
                @if ($news_item->content->organization !== NULL)
                <span>Associated with</span>
                <a href="" class = "org"> {{$news_item->content->organization->name}}</a>
                </div>
            @endif
        </div>
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