<div>
    <?php
    $follow_user = Auth::user()
        ->following()
        ->where('id_following', $user->id)
        ->first();
    ?>
    <input type="hidden" id="following" name="id_following" value="{{ $user->id }}">
    @if ($follow_user)
        <button id="follow" data-operation="unfollow">Unfollow</button>
    @else
        <button id="follow" data-operation="follow">Follow</button>
    @endif
</div>

<script type="text/javascript" src={{ url('js/profile.js') }} defer></script>
