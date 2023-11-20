<a href="{{ route('new', ['id' => $post->id]) }}">
    <article class="user_news">
        <h4 class="news_title">{{ $post->news_items()->first()->title }}</h2>
        <p class="news_content">{{ $post->content }}</p>
    </article>
</a>