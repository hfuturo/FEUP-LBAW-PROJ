<?php use Carbon\Carbon; ?>
@foreach ($news_list->paginate($perPage) as $newsItem)
    <a href=" {{ url('/news/' . $newsItem->id) }}">
        <article class="user_news">
            <header class="news_header_feed">
                <h4 class="news_title">{{ $newsItem->title }}</h4>
                <h4>{{ Carbon::parse($newsItem->date)->diffForHumans() }}</h4>
            </header>
            <p class="news_content">{{ $newsItem->content }}</p>
        </article>
    </a>
@endforeach
<span class="paginate">{{ $news_list->paginate($perPage)->links() }}</span>