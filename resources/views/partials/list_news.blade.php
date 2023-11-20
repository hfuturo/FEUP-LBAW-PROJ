@foreach ($news_list->paginate($perPage) as $newsItem)
    @include('partials.news', ['post' => $newsItem])
@endforeach
<span>{{ $news_list->paginate($perPage)->links() }}</span>