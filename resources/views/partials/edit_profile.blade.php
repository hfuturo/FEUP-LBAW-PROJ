<div id="edit_profile_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditForm()">&times;</span>
        <form method="POST" action="{{ route('profile_update', ['user' => Auth::user()]) }}">
            {{ csrf_field() }}
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ $user->name }}" required autofocus>
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="{{ $user->email }}" required>
            @error("email")
                <p class="input_error">{{ $message }}</p>
            @enderror
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ $user->bio }}</textarea>

            <button type="submit"> Save Changes </button>
        </form>
    </div>
</div>

<div class="user_follow_edit">
    <h2>
        {{ $user->name }}
    </h2>
    <button onclick="openEditForm()"><span class="material-symbols-outlined">edit</span></button>
</div>
