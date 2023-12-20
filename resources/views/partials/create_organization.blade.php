<div id="create_org_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeNewOrg()">&times;</span>
        <form method="POST" action="{{route('create_org')}}">
            @csrf
            <label for="name_org">Name</label>
            <input id="name_org" type="text" name="name" required placeholder="Name">
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <label for="bio_org">Bio</label>
            <textarea id="bio_org" name="bio" maxlength="1000" required placeholder="Something about the organization"></textarea>
            @error("bio")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <button type="submit"> Create </button>

            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
        </form>
    </div>
</div>