<div>
    <?php
    $follow_user = Auth::user()
        ->following()
        ->where('id_following', $user->id)
        ->first();
    ?>
    @if ($follow_user)
        <form action="{{ route('unfollow') }}" method="post">
            @csrf
            <input type="hidden" name="id_following" value="{{ $user->id }}">
            <button type="submit">Unfollow</button>
        </form>
    @else
        <form action="{{ route('follow') }}" method="post">
            @csrf
            <input type="hidden" name="id_following" value="{{ $user->id }}">
            <button type="submit">Follow</button>
        </form>
    @endif
</div>
