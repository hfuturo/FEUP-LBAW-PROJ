    <?php
    $follow_user = Auth::user()
        ->following()
        ->where('id_following', $user->id)
        ->first();
    ?>
    <input type="hidden" id="following" name="id_following" value="{{ $user->id }}">
    @if ($follow_user)
        <button id="follow" data-operation="unfollow"><span class="material-symbols-outlined">person_remove</span></button>
    @else
        <button id="follow" data-operation="follow"><span class="material-symbols-outlined">person_add</span></button>
    @endif
