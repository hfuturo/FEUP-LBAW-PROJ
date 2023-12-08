@extends('layouts.app')

@section('content')

<section class="info_section">
    <?php
    $follow_topic = Auth::user()
        ->follow_topics()
        ->where('id_topic', $topic->id)
        ->first();
    ?>
    <h2>{{ $topic->name }} </h2>
    Followers <span id="folowers_topic_count">{{ $topic->followers->count() }}</span>
    <input type="hidden" id="id_topic" name="id_topic" value="{{ $topic->id }}">
    @if ($follow_topic)
        <button id="follow_topic" data-operation="unfollow">Unfollow</button>
    @else
        <button id="follow_topic" data-operation="follow">Follow</button>
    @endif
    @include('partials.list_news', ['news_list' => $news, 'perPage' => 5])
</section>


@endsection