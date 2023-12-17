<div id="unblock_account_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeUnBlockForm()">&times;</span>
        <h2>Are you sure you want to unblock this user?</h2>
        <form method="POST" action="{{ route('block', ['user' => $user]) }}">
            @csrf
            <button class="block_button" type="submit">Unblock Account</button>
        </form>
    </div>
</div>

<button class="delete_button" onclick="openUnBlockForm()">Unblock Account</button>
