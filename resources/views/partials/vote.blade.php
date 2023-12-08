<div class="votes" id={{ $item->id }}>
    <button class='accept'>Like</button>
    <p>{{ $item->likes() }}</p>
    <button class='remove'>Dislike</button>
    <p>{{ $item->dislikes() }}</p>
</div>
