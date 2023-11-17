@foreach ($news_list->paginate($perPage) as $newsItem)
    @include('partials.item', ['news' => $newsItem])
@endforeach
<span>{{ $news_list->paginate($perPage)->links() }}</span>