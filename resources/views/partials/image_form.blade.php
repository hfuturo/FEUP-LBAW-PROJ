<button class="button" onclick="openEditPfpForm()">Edit Image</button>
<script>
    function openEditPfpForm() {
        Swal.fire({
            title: "Change the image!",
            html: `
            <form method="POST" action="/file/upload" enctype="multipart/form-data">
                @csrf
                <input name="file" type="file" required>
                <input name="type" type="text" value="profile" hidden>
            </form>
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
                    const reload = sessionStorage.getItem("reload-updated-pfp");
                    if (reload) {
                        sessionStorage.removeItem("reload-updated-pfp");
                    }
                    return true
                }
                return false
            }
        })
    }
</script>
