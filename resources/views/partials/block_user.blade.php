<div id="block_account_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeBlockForm()">&times;</span>
        <h2>Are you sure you want to block this user?</h2>
        <form method="POST" action="{{ route('block', ['user' => $user]) }}">
            @csrf
            <button class="block_button" type="submit">Block Account</button>
        </form>
    </div>
</div>

<button class="delete_button" onclick="openBlockForm()">Block Account</button>
