<li class="user" id="{{ $user->id }}">
    <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
    @if (Auth::user()->id !== $user->id)
        @if ($user->blocked)
            <button class="block" data-operation="unblock_user"><span class="material-symbols-outlined">done_outline
                </span></button>
        @else
            <button class="block" data-operation="block_user"><span class="material-symbols-outlined">block
                </span></button>
        @endif
        @if(!$user->is_admin())
            <button class="button upgrade" data-operation="upgrade_user">Upgrade to Administrator</button>
        @endif
    @endif
</li>
