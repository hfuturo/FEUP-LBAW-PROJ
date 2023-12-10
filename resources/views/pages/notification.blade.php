@extends('layouts.app')

@section('head')
    <link href="{{ url('css/info.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="info_section">
        @foreach ($notifications->paginate(10) as $notif)
            <article class="user_news">
                @if ($notif->notification->type === "follow")
                    <p><a href="{{ route('profile', ['user' => $notif->notification->user]) }}">{{ $notif->notification->user->name }}</a> is following you ! {{ $notif->date}}</p>
                @else
                @endif
            </article>
        @endforeach
        <span>{{ $notifications->paginate(10)->links() }}</span>
    </section>
@endsection
