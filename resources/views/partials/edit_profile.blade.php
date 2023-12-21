<div class="user_follow_edit">
    <h2>
        {{ $user->name }}
    </h2>
    <button onclick="openEditForm()"><span class="material-symbols-outlined">edit</span></button>
</div>
<script>
    function openEditForm() {
        Swal.fire({
            title: "Update your profile!",
            html: `
            <form method="POST" action="{{ route('profile_update', ['user' => Auth::user()]) }}">
            {{ csrf_field() }}
            <label for="name">Name *</label>
            <input id="name" type="text" name="name" value="{{ $user->name }}" required autofocus>
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror
            <label for="email">Email *</label>
            <input id="email" type="text" name="email" value="{{ $user->email }}" required>
            @error("email")
                <p class="input_error">{{ $message }}</p>
            @enderror
            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ $user->bio }}</textarea>

            </form>
            <p>(fields with * are mandatory)</p>

            `,
            confirmButtonColor: 'var(--primary-color)',
            customClass: {
                confirmButton: "button",
                cancelButton: "button",
            },
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            didOpen: () => {
                const popup = Swal.getPopup()
                popup.querySelector("form").addEventListener("submit", Swal.clickConfirm)
            },
            preConfirm: () => {
                const popup = Swal.getPopup()
                const form = popup.querySelector("form")
                if (form.reportValidity()) {
                    form.submit()
                    return true;
                }
                return false;
            }
        })
    }
    @if ($errors->has('name') || $errors->has('email'))
        openEditForm();
    @endif
</script>
