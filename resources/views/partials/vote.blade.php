<div class="votes" id="{{ $item->id }}">
    <?php
        $vote = Auth::user()->votes()->where('id_content', $item->id)->first();
    ?>
    @if ($vote)
        <input type="hidden" class="vote_value" name="vote_value" value="{{ $vote->vote }}">
    @endif
    <button class='vote accept'><span class="material-symbols-outlined">thumb_up</span></button>
    <p class="up_count">{{ $item->likes() }}</p>
    <button class='vote remove'><span class="material-symbols-outlined">thumb_down</span></button>
    <p class="down_count">{{ $item->dislikes() }}<p>
</div>