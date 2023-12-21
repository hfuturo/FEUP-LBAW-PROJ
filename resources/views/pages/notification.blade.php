@extends('layouts.app')
<?php use Carbon\Carbon; ?>

@section('content')
    <section id="list_notifications">
        <h2>Your Notifications</h2>
        @if ($notifications->get()->isEmpty())
            <p>There are no notifications to show.</p>
        @else
            @foreach ($notifications->paginate(10) as $notif)
                <article @if (!$notif->view) class="info_article new_notification" @else class="info_article" @endif
                    id="{{ $notif->notification->id }}">
                    <h4>
                        <button class="notification_button"><span
                                class="material-symbols-outlined icon_red">delete</span></button>
                        @if ($notif->notification->type === 'follow')
                            <div>
                                <a
                                    href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                is following you !
                            </div>
                        @endif
                        @if ($notif->notification->type === 'content')
                            <div>
                                <a
                                    href="{{ route('news_page', ['id' => $notif->notification->content->comments->news_item->id]) }}">{{ $notif->notification->content->comments->news_item->title }}</a>
                                has a new comment, go check !
                            </div>
                        @endif
                        @if ($notif->notification->type === 'vote')
                            @if ($notif->notification->content->news_items)
                                <div>
                                    <a
                                        href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                    voted on your news item. <a
                                        href="{{ route('news_page', ['id' => $notif->notification->content->news_items->id]) }}">{{ $notif->notification->content->news_items->title }}</a>
                                </div>
                            @endif
                            @if ($notif->notification->content->comments)
                                <div>
                                    <a
                                        href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a>
                                    voted on your comment in <a
                                        href="{{ route('news_page', ['id' => $notif->notification->content->comments->news_item->id]) . '?comment=' . $notif->notification->content->comments->id . '#comment' . $notif->notification->content->comments->id }}">{{ $notif->notification->content->comments->news_item->title }}</a>
                                </div>
                            @endif
                        @endif
                        <p>{{ explode('.', date('Y/m/d H:i:s', Carbon::parse($notif->date)->timestamp))[0] }}</p>
                    </h4>
                </article>
            @endforeach
        @endif
        <span>{{ $notifications->paginate(10)->links() }}</span>
    </section>
@endsection
