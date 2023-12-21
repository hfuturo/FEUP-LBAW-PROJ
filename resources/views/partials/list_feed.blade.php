<?php
use Carbon\Carbon;

$paginator = $news_list->paginate($perPage);
if (isset($basePath)) {
    $paginator->withPath($basePath);
} else {
    $paginator->withPath('/' . request()->path());
}
$paginator = $paginator->withQueryString();
?>
@foreach ($paginator as $newsItem)
    <a href=" {{ url('/news/' . $newsItem->id) }}">
        <article class="news">
            <div class="news_header_feed">
                <h4 class="news_title">{{ $newsItem->title }}</h4>
                <h5 class="time_elapsed">{{ Carbon::parse($newsItem->date)->diffForHumans() }}</h5>
            </div>
            <p class="news_content">{{ $newsItem->content }}</p>
        </article>
    </a>
@endforeach
<span class="paginate">{{ $paginator->links() }}</span>
