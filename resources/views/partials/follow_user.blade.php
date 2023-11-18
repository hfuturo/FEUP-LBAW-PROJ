<div>
    <?php
        $follow_user = Auth::user()->following()->where('id_following', $user->id)->first();
    ?>
    @if ($follow_user)
        <form action="{{ route('unfollow', ['id_follower' => Auth::user()->id, 'id_following' => $user->id]) }}" method="post">
            @csrf
            <button type="submit">Unfollow</button>
        </form>
    @else
        <form action="{{ route('follow', ['id_follower' => Auth::user()->id, 'id_following' => $user->id]) }}" method="post">
            @csrf
            <button type="submit">Follow</button>
        </form>
    @endif
</div>