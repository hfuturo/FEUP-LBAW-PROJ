@extends('layouts.app')

@section('head')
    <script type="text/javascript" src={{ url('js/appeals.js') }} defer></script>
@endsection

@section('content')
    <section id="list_unblock_appeals">
        <h2>List Unblock Appeals</h2>
        @if ($users->isEmpty())
            There are no unblock appeals to show.
        @else
            @foreach ($users as $user)
                <article class="user_news">
                    <h4 id="{{ $user->id }}">
                        User:
                        <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
                    </h4>
                    <p>Justification: {{ $user->blocked_appeal }}</p>
                    <span class="container_choices">
                        <button class="remove reject_appeal">Reject appeal</button>
                        <button class="accept unblock_user">Unblock user</button>
                    </span>
                </article>
            @endforeach
        @endif
        <span>{{ $users->links() }}</span>
    </section>
@endsection
