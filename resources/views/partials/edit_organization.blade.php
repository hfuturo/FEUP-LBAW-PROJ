<div id="edit_profile_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEditForm()">&times;</span>
        <form id="editOrgForm"  data-org-id="{{ $organization->id }}">
            {{ csrf_field() }}
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ $organization->name }}" required autofocus>
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ $organization->bio }}</textarea>
            @error("bio")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <button type="submit"> Save Changes </button>
        </form>
    </div>
</div>