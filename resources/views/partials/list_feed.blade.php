<?php

use Carbon\Carbon;

$paginator = $news_list->paginate($perPage);
if (isset($basePath)) {
    $paginator->withPath($basePath);
}
if (app('request')->input('search') != null) {
    $paginator->appends(['search' => app('request')->input('search')]);
}
if (app('request')->input('search_type') != null) {
    $paginator->appends(['search_type' => app('request')->input('search_type')]);
}
?>
@foreach ($paginator as $newsItem)
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
<span class="paginate">{{ $paginator->links() }}</span>
