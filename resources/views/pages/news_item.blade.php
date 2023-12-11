@extends('layouts.app')
<?php use Carbon\Carbon; ?>

@section('head')
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <link href="{{ url('css/comments.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/vote.js') }} defer></script>
@endsection

@section('content')
    <section id = "news">
        @if (Auth::check() && $news_item->content->authenticated_user !== null)
            @if (Auth::user()->id === $news_item->content->authenticated_user->id)
                <form action="{{ route('destroy', ['id' => $news_item->id]) }}" method="post">
                    @csrf
                    <button type="submit">Delete</button>
                    <a href="{{ route('edit_news', ['id' => $news_item->id]) }}" class="button"
                        style="display:inline-block;">Edit
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
                    <div class="post_owner_info_wrapper">
                        <span>Posted by</span>
                        @if ($news_item->content->authenticated_user !== null)
                            <img class="author_post_pfp"
                                src="{{ $news_item->content->authenticated_user->getProfileImage() }}">
                            <a href="{{ route('profile', ['user' => $news_item->content->authenticated_user]) }}"
                                class = "author">{{ $news_item->content->authenticated_user->name }}</a>
                        @else
                            <p class="author">Anonymous</p>
                        @endif
                        @if ($news_item->content->organization !== null)
                            <span>Associated with</span>
                            <a href="" class = "org"> {{ $news_item->content->organization->name }}</a>
                        @endif
                    </div>
                @endif
            </div>
            @if ($news_item->image !== null)
                <img class="post_image" src="/post/{{ $news_item->image }}" alt="{{ $news_item->title }}">
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
                        <a href="{{ route('tag', ['tag' => $tag->id]) }}" class="tag">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @include('partials.vote', ['item' => $news_item])
            @endif
        </article>
    </section>
    <section id = "new_comment">
        <div class="header">
            <h3>Leave a comment</h3>
        </div>
        <form id="commentForm" data-news-id="{{ $news_item->id }}">
            @csrf
            <textarea id="commentContent" name="content" rows="3" maxlength="500" required
                placeholder="Write your comment here"></textarea>
            <button type="submit" class="button" id="postComment">Post</button>
        </form>
    </section>
    <section id = "comments">
        @if ($comments->count() === 0)
            <div id="no_comments">
                <p> There are no comments yet</p>
            </div>
        @else
            @foreach ($comments as $comment)
                <article class="comment" comment-id="{{ $comment->id }}">
                    <div class="comment_header">
                        @if (Auth::check())
                            @if ($comment->content->authenticated_user !== null)
                                <img class="author_comment_pfp"
                                    src="{{ $comment->content->authenticated_user->getProfileImage() }}">
                                <a href="{{ route('profile', ['user' => $comment->content->authenticated_user->id]) }}"
                                    class="comment_author">
                                    {{ $comment->content->authenticated_user->name }}</a>
                                @if ($news_item->content->authenticated_user->id === $comment->content->authenticated_user->id) 
                                    <span class="material-symbols-outlined author">person_edit</span>
                                @endif
                            @else
                                <p class="comment_author">Anonymous</p>
                            @endif
                            <p class=date> {{ Carbon::parse($comment->content->date)->diffForHumans() }}</p>
                            @if ($comment->content->edit_date !== null)
                                <p class="date">Edit {{Carbon::parse($comment->content->edit_date)->diffForHumans() }}</p>
                            @endif
                            <div class="dropdown">
                                <button class="more" onclick="toggleMenu(this, event)">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </button>
                                <div class="dropdown-content">
                                    <div class="dropdown-option">
                                        <span class="material-symbols-outlined">flag</span>
                                        <span>Report</span>
                                    </div>
                                    @if(Auth::user()->id === $comment->content->authenticated_user->id)
                                        <div class="dropdown-option delete">
                                            <span class="material-symbols-outlined">delete</span>
                                            <span class="delete">Delete</span>
                                        </div>
                                        <div class="dropdown-option edit">
                                            <span class="material-symbols-outlined">edit</span>
                                            <span class="edit">Edit</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    <form class="editForm" hidden>
                        @csrf
                        <textarea class="commentContent" name="content" rows="3" maxlength="500" required>{{ $comment->content->content}}</textarea>
                        <div class=buttonsForm>
                            <button type="submit" class="button editButton">Edit</button>
                            <button type="button" class="button cancelButton" onclick="editCancel(this.closest('.comment'))">Cancel</button>
                        </div>
                    </form>
                    <p class="comment_text">{{ $comment->content->content }}</p>
                    @if (Auth::check())
                        @include('partials.vote', ['item' => $comment])
                    @endif
                </article>
            @endforeach
            <div id="pag">
                {{ $comments->links() }}
            </div>
        @endif
    </section>
@endsection
