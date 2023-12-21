@extends('layouts.app')
<?php
use App\Models\Content;
?>
@section('head')
    <link href="{{ url('css/manage.css') }}" rel="stylesheet">
    <script type="text/javascript" src={{ url('js/manage.js') }} defer></script>
@endsection


@section('content')
    <section id="topics">
        <h2>List of Topics</h2>
        <input id="filter_topics" name="filter_topics" placeholder="Topic's name">
        <nav id="all_topics">
            @foreach ($topics as $topic)
                <?php
                $news = Content::join('news_item', 'content.id', '=', 'news_item.id')
                    ->where('news_item.id_topic', '=', $topic->id)
                    ->select('content.*', 'news_item.*');
                ?>
                <li class="topic">
                    <a href="{{ route('topic', ['topic' => $topic->id]) }}">{{ $topic->name }}</a>
                    <div class="manage_div">
                        <p>Number of news: {{ $news->count() }}</p>
                        <p>Followers: {{ $topic->followers->count() }}</p>
                    </div>
                </li>
            @endforeach
        </nav>
    </section>
@endsection
