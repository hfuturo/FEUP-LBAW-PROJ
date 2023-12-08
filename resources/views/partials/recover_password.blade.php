<div id="recover_password_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeRecoverPasswordForm()">&times;</span>
        <form method="POST" action="{{ route('send_email') }}">
            @csrf
            <label for="user_email">Email</label>
            <input id="user_email" type="email" name="email" placeholder="Email" required>
            <button type="submit">Send</button>
        </form>
    </div>
</div>