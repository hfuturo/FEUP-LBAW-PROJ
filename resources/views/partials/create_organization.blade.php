<script>
    function openNewOrg() {
        Swal.fire({
            title: "Create a new organization!",
            html: `
<form method="POST" action="{{route('create_org')}}">
    {{ csrf_field() }}
    <label for="name_org">Name *</label>
    <input id="name_org" type="text" name="name_org" required placeholder="Name">
    @error("name_org")
        <p class="input_error">{{ $message }}</p>
    @enderror
    <label for="bio_org">Bio *</label>
    <textarea id="bio_org" name="bio_org" maxlength="1000" required placeholder="Something about the organization"></textarea>
    @error("bio_org")
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
                    return true;
                }
                return false;
            }
        })
    }
    @if ($errors->has('name_org') || $errors->has('bio_org'))
        openNewOrg();
    @endif
</script>
