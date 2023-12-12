@extends('layouts.app')

@section('head')
@endsection

@section('content')
    <section id="list_notifications">
        <h2>Your Notifications</h2>
        @if ($notifications->get()->isEmpty())
            <p>There are no notifications to show.</p>
        @else
            @foreach ($notifications->paginate(10) as $notif)
                <article class="user_news" id="{{ $notif->notification->id }}">
                    <h4>
                    <button class="notification_button"><span class="material-symbols-outlined icon_red">delete</span></button>
                    @if ($notif->notification->type === "follow")
                            <a href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a> is following you !
                    @endif
                    @if ($notif->notification->type === "content")
                            <a href="{{ route('news_page', ['id' => $notif->notification->content->comments->news_item->id]) }}">{{ $notif->notification->content->comments->news_item->title }}</a> has a new comment, go check !
                    @endif
                    </h4>
                    <p>{{ $notif->date}}</p>
                </article>
            @endforeach
        @endif
        <span>{{ $notifications->paginate(10)->links() }}</span>
    </section>
@endsection
