@extends('layouts.app')
<?php
use Carbon\Carbon;
use App\Http\Controllers\FileController;
?>

@section('head')
    <link href="{{ url('css/news.css') }}" rel="stylesheet">
    <link href="{{ url('css/comments.css') }}" rel="stylesheet">
    @if (Auth::check())
        <script type="text/javascript" src={{ url('js/vote.js') }} defer></script>
    @endif
    <script type="text/javascript" src={{ url('js/comments.js') }} defer></script>
@endsection

@section('content')

    <section id = "news">
        <article class = "news_body">
            <div class = "news_head">
                @if (Auth::check())
                    <div id="teste">
                        <a href="{{ route('topic', ['topic' => $news_item->topic->id]) }}">{{ $news_item->topic->name }}</a>
                        <div class="dropdown">
                            <button class="more" onclick="toggleMenu(this, event)">
                                <span class="material-symbols-outlined">more_vert</span>
                            </button>
                            <div class="dropdown-content hidden">
                                @if (!$news_item->content->authenticated_user || Auth::user()->id !== $news_item->content->authenticated_user->id)
                                    <button class="dropdown-option" onclick="openReportNewsForm({{ $news_item->id }})">
                                        <span class="material-symbols-outlined">flag</span>
                                        <span>Report</span>
                                    </button>
                                @else
                                    <form id="deleteForm"
                                        action="{{ route('destroy', ['id' => $news_item->id]) }}"method="post">
                                        @csrf
                                    </form>
                                    <button class="dropdown-option delete" type="submit" form="deleteForm">
                                        <span class="material-symbols-outlined">delete</span>
                                        <span>Delete</span>
                                    </button>
                                    <a class="dropdown-option edit"
                                        href="{{ route('edit_news', ['id' => $news_item->id]) }}">
                                        <span class="material-symbols-outlined">edit</span>
                                        <span>Edit</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <h2 class = "title">{{ $news_item->title }}</h2>
                @if (Auth::check())
                    <div class="post_owner_info_wrapper">
                        <span>Posted by</span>
                        @if ($news_item->content->authenticated_user !== null)
                            <img class="author_post_pfp"
                                src="{{ $news_item->content->authenticated_user->getProfileImage() }}"
                                alt="User Profile Picture">
                            <a href="{{ route('profile', ['user' => $news_item->content->authenticated_user]) }}"
                                class = "author">{{ $news_item->content->authenticated_user->name }}</a>
                        @else
                            <img class="author_post_pfp" src="{{ asset('profile/pfp_default.jpeg') }}"
                                alt="User Profile Picture">
                            <p class="author">&nbsp;Anonymous</p>
                        @endif
                        @if ($news_item->content->organization !== null)
                            <span>Associated with</span>
                            <a href="{{ route('show_org', ['organization' => $news_item->content->organization]) }}"
                                class = "org"> {{ $news_item->content->organization->name }}</a>
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
                        <a href="{{ route('tag', ['tag' => $tag->id]) }}" class="button">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @include('partials.vote', ['item' => $news_item])
            @endif
        </article>
    </section>
    @if (Auth::check())
        <section id = "new_comment">
            <h3>Leave a comment</h3>
            <form id="commentForm" data-news-id="{{ $news_item->id }}">
                @csrf
                <textarea id="commentContent" name="content" rows="3" maxlength="500" required
                    placeholder="Write your comment here"></textarea>
                <button type="submit" class="button" id="postComment">Post</button>
            </form>
        </section>
    @endif
    <section id = "comments">
        <h3>Comments</h3>
        <form class="search_form" action="#comments">
            <input name="search" placeholder="Search">
            <button type="submit" class="button button-secondary"><svg focusable="false" style="scale: 1.3;"
                    xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                    </path>
                </svg></button>
        </form>
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
                                    src="{{ $comment->content->authenticated_user->getProfileImage() }}"
                                    alt="User Profile Picture">
                                <a href="{{ route('profile', ['user' => $comment->content->authenticated_user->id]) }}"
                                    class="comment_author">
                                    {{ $comment->content->authenticated_user->name }}</a>
                                @if (
                                    $news_item->content->authenticated_user &&
                                        $news_item->content->authenticated_user->id === $comment->content->authenticated_user->id)
                                    <span class="material-symbols-outlined author">person_edit</span>
                                @endif
                            @else
                                <img class="author_comment_pfp" src={{ asset('profile/pfp_default.jpeg') }}
                                    alt="User Profile Picture">
                                <p class="comment_author"> Anonymous</p>
                            @endif
                            <p class=date> {{ Carbon::parse($comment->content->date)->diffForHumans() }}</p>
                            @if ($comment->content->edit_date !== null)
                                <p class="date" id="edit_date">Edited
                                    {{ Carbon::parse($comment->content->edit_date)->diffForHumans() }}</p>
                            @endif
                            @if ($comment->content->authenticated_user)
                                <div class="dropdown">
                                    <button class="more" onclick="toggleMenu(this, event)">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                    <div class="dropdown-content hidden">
                                        @if (Auth::user()->id !== $comment->content->authenticated_user->id)
                                            <div class="dropdown-option report">
                                                <span class="material-symbols-outlined">flag</span>
                                                <span>Report</span>
                                            </div>
                                        @endif
                                        @if (Auth::user()->is_admin() || Auth::user()->id === $comment->content->authenticated_user->id)
                                            <div class="dropdown-option delete">
                                                <span class="material-symbols-outlined">delete</span>
                                                <span class="delete">Delete</span>
                                            </div>
                                        @endif
                                        @if (Auth::user()->id === $comment->content->authenticated_user->id)
                                            <div class="dropdown-option edit">
                                                <span class="material-symbols-outlined">edit</span>
                                                <span class="edit">Edit</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <form class="editForm" hidden>
                        @csrf
                        <textarea class="commentContent" name="content" rows="3" maxlength="500" required>{{ $comment->content->content }}</textarea>
                        <div class="buttonsForm">
                            <button type="submit" class="button editButton">Edit</button>
                            <button type="button" class="button cancelButton"
                                onclick="editCancel(this.closest('.comment'))">Cancel</button>
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
    @include('partials.report_content')
@endsection
