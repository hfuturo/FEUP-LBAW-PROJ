<li class="user" id="{{ $user->id }}">
    @if ($user->blocked)
        <button class="block" data-operation="unblock_user">Unblock</button>
    @else
        <button class="block" data-operation="block_user">Block</button>
    @endif
    <a href="{{ route('profile', ['user' => $user->id]) }}">{{ $user->name }}</a>
</li>
