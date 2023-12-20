<article class="user_news">
    <a href="{{ route('news_page', ['id' => $post->id]) }}"><h4 class="news_title">{{ $post->news_items()->first()->title }}</h4></a>
    <p class="news_content">{{ $post->content }}</p>
    @include('partials.vote', ['item' => $post->news_items])
</article>
