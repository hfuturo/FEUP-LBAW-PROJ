<div>
    <?php
    $follow_user = Auth::user()
        ->following()
        ->where('id_following', $user->id)
        ->first();
    ?>
    <input type="hidden" id="following" name="id_following" value="{{ $user->id }}">
    @if ($follow_user)
            <button onclick=follow(event) id="unfollow">Unfollow</button>
    @else
            <button onclick=follow(event) id="follow">Follow</button>
        </form>
    @endif
</div>

<script type="text/javascript" src={{ url('js/profile.js') }} defer></script>
