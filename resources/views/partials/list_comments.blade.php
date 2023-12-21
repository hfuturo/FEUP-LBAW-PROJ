<?php
use Carbon\Carbon;

$paginator = $comments->paginate($perPage);
if (isset($basePath)) {
    $paginator->withPath($basePath);
}
$paginator = $paginator->withQueryString();
?>


@if ($paginator->count() === 0)
    <div id="no_comments">
        <p> There are no comments yet</p>
    </div>
@else
    @foreach ($paginator as $comment)
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
                                    <button class="dropdown-option report" onclick="openReportCommentForm(this)">
                                        <span class="material-symbols-outlined">flag</span>
                                        <span>Report</span>
                                    </button>
                                @endif
                                @if (Auth::user()->is_admin() || Auth::user()->id === $comment->content->authenticated_user->id)
                                    <button class="dropdown-option delete" onclick="deleteCommentItem(this)">
                                        <span class="material-symbols-outlined">delete</span>
                                        <span class="delete">Delete</span>
                                    </button>
                                @endif
                                @if (Auth::user()->id === $comment->content->authenticated_user->id)
                                    <button class="dropdown-option edit" onclick="editCommentItem(this)">
                                        <span class="material-symbols-outlined">edit</span>
                                        <span class="edit">Edit</span>
                                    </button>
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
@endif
<span class="paginate">{{ $paginator->links() }}</span>
