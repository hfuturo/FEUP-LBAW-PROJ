<li class="user" id="{{ $user->id }}">
    <div>
        <div class="name_wrapper">
            <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
        </div>
        @if ($user->topic !== null)
            <a href="{{ route('topic', ['topic' => $user->topic]) }}" class="is_mod">Moderator of
                {{ $user->topic->name }}</a>
        @endif
        @if ($user->is_admin())
            <span class="admin">Admin</span>
        @endif
    </div>
    @if (Auth::user()->id !== $user->id)
        <div>
            @if ($user->blocked)
                <button class="unblock button" data-operation="unblock_user"><span>Unblock</span></button>
            @else
                @if (!$user->is_admin())
                    @if ($user->topic === null)
                        <button class="text modBut button" onclick="openMakeModeratorTopic(this)">Upgrade to
                            Moderator</button>
                    @else
                        <button class="text modBut button" onclick="revokeModerator(this)">Revoke Moderator</button>
                    @endif
                @endif
                @if (!$user->is_admin())
                    <button class="button upgrade" data-operation="upgrade_user">Upgrade to Administrator</button>
                @endif
                @if (!$user->is_admin())
                    <button class="block button" data-operation="block_user"><span>Block</span></button>
                @endif
            @endif
        </div>
    @endif
</li>
