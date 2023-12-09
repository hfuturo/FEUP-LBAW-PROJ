<div id="delete_account_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeDeleteForm()">&times;</span>
        @if (Auth::user()->id === $user->id)
            <h2>Are you sure you want to delete your account?</h2>
        @else
            <h2>Are you sure you want to delete this account?</h2>
        @endif
        <form method="POST" action="{{ route('delete_account', ['user' => $user]) }}">
            {{ csrf_field() }}
            <button class="delete_button" type="submit">Delete Account</button>
        </form>
    </div>
</div>

<button class="delete_button" onclick="openDeleteForm()">Delete Account</button>
