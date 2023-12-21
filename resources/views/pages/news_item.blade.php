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
                                    <button class="dropdown-option" onclick="openReportContentForm({{ $news_item->id }})">
                                        <span class="material-symbols-outlined">flag</span>
                                        <span>Report</span>
                                    </button>
                                    @if (Auth::user()->is_admin())
                                        <form id="deleteForm" action="{{ route('destroy', ['id' => $news_item->id]) }}"
                                            method="post">
                                            @csrf
                                            <button class="dropdown-option delete" type="submit" form="deleteForm">
                                                <span class="material-symbols-outlined">delete</span>
                                                <span>Delete</span>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <form id="deleteForm" action="{{ route('destroy', ['id' => $news_item->id]) }}"
                                        method="post">
                                        @csrf
                                        <button class="dropdown-option delete" type="submit" form="deleteForm">
                                            <span class="material-symbols-outlined">delete</span>
                                            <span>Delete</span>
                                        </button>
                                    </form>
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
                        <span class = "date"> Edited last time
                            {{ explode('.', date('Y/m/d H:i:s', Carbon::parse($news_item->content->edit_date)->timestamp))[0] }}</span>
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
        @include('partials.list_comments', [
            'news_item' => $news_item,
            'comments' => $comments,
            'perPage' => $perPage,
        ])
    </section>
    @include('partials.report_content')
@endsection
