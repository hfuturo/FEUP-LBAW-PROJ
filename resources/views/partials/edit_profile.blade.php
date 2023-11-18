<div id="edit_profile_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditForm()">&times;</span>
        <form method="POST" action="{{ route('profile_update', ['user' => Auth::user()]) }}">
            {{ csrf_field() }}
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ $user->name }}" required autofocus>

            <label for="email" >Email</label>
            <input id="email" type="text" name="email" value="{{ $user->email }}" required>

            <label for="bio" >Bio</label>
            <input id="bio" type="text" name="bio" value="{{ $user->bio }}" >

            <button type="submit"> Save Changes </button>

            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
        </form>
    </div>
</div>

<button class="button" onclick="openEditForm()">Edit</button>