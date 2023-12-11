<div id="create_org_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeNewOrg()">&times;</span>
        <form method="POST" action="{{ route('create_org')}}">
            @csrf

            <input id="leader" type="number" name="leader" hidden value="{{Auth::user()->id}}">

            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autofocus>

            <label for="bio">Bio</label>
            <textarea id="bio" name="bio" maxlength="1000"></textarea>

            <button type="submit"> Create </button>

            @if (session('success'))
                <p class="success">
                    {{ session('success') }}
                </p>
            @endif
        </form>
    </div>
</div>