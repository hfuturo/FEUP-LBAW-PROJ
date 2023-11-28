<div class="votes" id={{ $item->id }}>
    <button class='accept'><span class="material-symbols-outlined">thumb_up</span></button>
    <p>{{ $item->likes() }}</p>
    <button class='remove'><span class="material-symbols-outlined">thumb_down</span></button>
    <p>{{ $item->dislikes() }}<p>
</div>