<li class="user" id="{{ $user->id }}">
    <div>
        <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
        @if ($user->topic !== null)
            <a href="{{ route('topic', ['topic' => $user->topic]) }}" class="is_mod">Moderator of
                {{ $user->topic->name }}</a>
        @endif
    </div>
    @if (Auth::user()->id !== $user->id)
        @if ($user->blocked)
            <button class="block" data-operation="unblock_user"><span
                    class="material-symbols-outlined">done_outline</span></button>
        @else
            <button class="block" data-operation="block_user"><span
                    class="material-symbols-outlined">block</span></button>
            @if ($user->topic === null)
                <button class="text modBut button" onclick="openMakeModeratorTopic(this)">Make Moderator</button>
            @else
                <button class="text modBut button" onclick="revokeModerator(this)">Revoke Moderator</button>
            @endif
            @if (!$user->is_admin())
                <button class="button upgrade" data-operation="upgrade_user">Upgrade to Administrator</button>
            @endif
        @endif
    @endif
</li>
