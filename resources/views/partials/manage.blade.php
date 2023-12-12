<li class="user" id="{{ $user->id }}">
    <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
    @if ($user->blocked)
        <button class="block" data-operation="unblock_user"><span class="material-symbols-outlined">done_outline
            </span></button>
    @else
        <button class="block" data-operation="block_user"><span class="material-symbols-outlined">block
            </span></button>
    @endif
</li>
