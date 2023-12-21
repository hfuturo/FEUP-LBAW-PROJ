<script>
    function openEditForm() {
        Swal.fire({
            title: "Update your organization!",
            html: `
            <form method="POST" id="editOrgForm" action="{{url('/api/organization/update')}}">
            {{ csrf_field() }}
            <input id="orgId" type="hidden" name="orgId" value="{{ $organization->id }}">
            <label for="name">Name *</label>
            <input id="name" type="text" name="name" value="{{ $organization->name }}" required>
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <label for="bio">Bio</label>
            <textarea id="bio" name="bio">{{ $organization->bio }}</textarea>
            @error("bio")
                <p class="input_error">{{ $message }}</p>
            @enderror
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
                    return true
                }
                return false
            }
        }
    )}
    @if ($errors->has('name') || $errors->has('bio'))
        openEditForm();
    @endif
</script>
