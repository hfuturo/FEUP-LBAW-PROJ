<?php
use Carbon\Carbon;
function findObjectById($array, $id)
{
    for ($i = 0; $i < count($array); $i++) {
        if ($id == $array[$i]->id) {
            return $i;
        }
    }

    return null;
}

$c = $comments->get();
$index = null;
if (!app('request')->has('page')) {
    $index = findObjectById($c, app('request')->input('comment'));
}
$paginator = $comments->paginate($perPage, ['*'], 'page', $index != null ? intdiv($index, $perPage) + 1 : null);

if (isset($basePath)) {
    $paginator->withPath($basePath);
}
$paginator = $paginator->appends(app('request')->except(['comment']));
?>

<h3>Comments <span>({{ $paginator->total() }})</span></h3>
<form class="search_form" action="#comments">
    <input name="comment_search" placeholder="Search" value="{{ app('request')->input('comment_search') }}">
    <button type="submit" class="button button-secondary"><svg focusable="false" style="scale: 1.3;"
            xmlns=" http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path
                d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
            </path>
        </svg></button>
</form>

@if ($paginator->count() === 0)
    <div id="no_comments">
        <p> There are no comments yet</p>
    </div>
@else
    @foreach ($paginator as $comment)
        <article class="comment" comment-id="{{ $comment->id }}" id="comment{{ $comment->id }}">
            <div class="comment_header">
                @if (Auth::check())
                    @if ($comment->id_author !== null)
                        <img class="author_comment_pfp" src="/profile/{{ $comment->image }}" alt="User Profile Picture">
                        <a href="{{ route('profile', ['user' => $comment->id_author]) }}" class="comment_author">
                            {{ $comment->name }}</a>
                        @if ($news_item->id_author && $news_item->id_author === $comment->id_author)
                            <span class="material-symbols-outlined author">person_edit</span>
                        @endif
                    @else
                        <img class="author_comment_pfp" src={{ asset('profile/pfp_default.jpeg') }}
                            alt="User Profile Picture">
                        <p class="comment_author"> Anonymous</p>
                    @endif
                    <p class=date> {{ Carbon::parse($comment->date)->diffForHumans() }}</p>
                    @if ($comment->edit_date !== null)
                        <p class="date edit_date">Edited
                            {{ Carbon::parse($comment->edit_date)->diffForHumans() }}</p>
                    @endif
                    <div class="dropdown">
                        <button class="more" onclick="toggleMenu(this, event)">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                        <div class="dropdown-content hidden">
                            @if (Auth::user()->id !== $comment->id_author)
                                <button class="dropdown-option report" onclick="openReportCommentForm(this)">
                                    <span class="material-symbols-outlined">flag</span>
                                    <span>Report</span>
                                </button>
                            @endif
                            @if (Auth::user()->is_admin() || Auth::user()->id === $comment->id_author)
                                <button class="dropdown-option delete" onclick="deleteCommentItem(this)">
                                    <span class="material-symbols-outlined">delete</span>
                                    <span class="delete">Delete</span>
                                </button>
                            @endif
                            @if (Auth::user()->id === $comment->id_author)
                                <button class="dropdown-option edit" onclick="editCommentItem(this)">
                                    <span class="material-symbols-outlined">edit</span>
                                    <span class="edit">Edit</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <form class="editForm" hidden>
                @csrf
                <label>Leave a comment</label>
                <textarea class="commentContent" name="content" rows="3" maxlength="500" required>{{ $comment->content }}</textarea>
                <div class="buttonsForm">
                    <button type="submit" class="button editButton">Edit</button>
                    <button type="button" class="button cancelButton"
                        onclick="editCancel(this.closest('.comment'))">Cancel</button>
                </div>
            </form>
            <p class="comment_text">{{ $comment->content }}</p>
            @if (Auth::check())
                @include('partials.vote', ['item' => $comment])
            @endif
        </article>
    @endforeach
@endif
<span class="paginate">{{ $paginator->links() }}</span>
