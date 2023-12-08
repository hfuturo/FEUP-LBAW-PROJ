@extends('layouts.app')
<?php
use Carbon\Carbon;
?>

@section('content')

    <section id = "news">
        @include('partials.error_message')
        @if (Auth::check() && $news_item->content->authenticated_user !== null)
            @if (Auth::user()->id === $news_item->content->authenticated_user->id)
                <form action="{{ route('destroy', ['id' => $news_item->id]) }}" method="post">
                    @csrf
                    <button type="submit">Delete</button>
                    <a href="{{ route('edit_news', ['id' => $news_item->id]) }}" class="button" style="display:inline-block;">Edit
                        Post</a>
                </form>
            @endif
        @endif
        <article class = "news_body">
            <div class = "news_head">
                @if (Auth::check())
                    <a href="{{ route('topic', ['topic' => $news_item->topic->id]) }}">{{ $news_item->topic->name }}</a>
                @endif
                <h2 class = "title">{{ $news_item->title }}</h2>
                @if (Auth::check())
                    <span>Posted by</span>
                    @if ($news_item->content->authenticated_user !== null)
                        <a href="{{ route('profile', ['user' => $news_item->content->authenticated_user]) }}"
                        class = "author">{{ $news_item->content->authenticated_user->name }}</a>
                    @else
                        <p class="author">Anonymous</p>
                    @endif
                    @if ($news_item->content->organization !== null)
                        <span>Associated with</span>
                        <a href="" class = "org"> {{ $news_item->content->organization->name }}</a>
                    @endif
                @endif
            </div>
            @if ($news_item->image !== null)
                <img src="/img/news_image/{{ $news_item->image }}" alt="{{ $news_item->title }}">
            @endif
            <p class = "news_text">{{ $news_item->content->content }}</p>

            @if (Auth::check())
                <div class="dates">
                    <span
                        class = "date">{{ explode('.', date('Y/m/d H:i:s', Carbon::parse($news_item->content->date)->timestamp))[0] }}</span>
                    @if ($news_item->content->edit_date !== null)
                        <span class = "date">Edited last time</span>
                        <span
                            class = "date">{{ explode('.', date('Y/m/d H:i:s', Carbon::parse($news_item->content->edit_date)->timestamp))[0] }}</span>
                    @endif
                </div>
                <div class=tags>
                    @foreach ($news_item->tags as $tag)
                        <a href="" class="tag">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @include('partials.vote',['item' => $news_item])
            @endif
        </article>
    </section>
    <section id = "comments">
        @if ($comments->count() === 0)
            <p class="not_comments"> There are no comments yet</p>
        @else
            @foreach ($comments as $comment)
                <article class="comment">
                    <div class="comment_header">
                        @if (Auth::check())
                            @if ($comment->content->authenticated_user !== null)
                                <a href="" class="comment_author"> {{ $comment->content->authenticated_user->name }}</a>
                            @else
                                <p class="comment_author">Anonymous</p>
                            @endif
                            <p class=date> {{ $comment->content->date }}</p>
                            @if ($comment->content->edit_date !== null)
                                <p class=date> {{ $comment->content->edit_date }}</p>
                            @endif
                        @endif
                    </div>
                    <p class="comment_text">{{ $comment->content->content }}</p>
                    @if (Auth::check())
                        @include('partials.vote',['item' => $comment])
                    @endif
                </article>
            @endforeach
            <div id="pag">
                {{ $comments->links() }}
            </div>
        @endif
    </section>

@endsection
