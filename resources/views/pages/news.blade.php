@extends('layouts.app')

@section('content')

<div class="feed_buttons">
    <button class="feed_button top_feed">Top Feed</button>
    @if (Auth::check())
    <button class="feed_button follow_feed">Following Feed</button>
    @endif
    <button class="feed_button recent_feed">Recent Feed</button>
</div>
<div class="all_news">
    @include('partials.list_feed', ['news_list' => DB::table('news_item')->select(DB::raw('content.*, news_item.title, sum(vote.vote)'))->leftJoin('vote','vote.id_content','=','news_item.id')->join('content','content.id','=','news_item.id')->groupBy('news_item.id')->groupBy('content.id')->orderByRaw('sum(vote.vote) DESC'), 'perPage' => 10])
</div>

@endsection