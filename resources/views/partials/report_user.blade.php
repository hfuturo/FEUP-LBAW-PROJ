<button onclick="openReportUserForm()">Report</button>
<script>
    function openReportUserForm() {
        Swal.fire({
            title: "Report",
            html: `
    <form method="POST">
        {{ csrf_field() }}
        <input type="hidden" id="reported" name="id_reported" value="{{ $user->id }}">
        <label for="reason">Reason</label>
        <textarea id="reason" name="reason"></textarea>
        @error("reason")
            <p class="report_error">{{ $message }}</p>
        @enderror
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
                    console.log(getFormParams(form));
                    sendFetchRequest(form.method, "/api/profile/report", getFormParams(form));
                    Swal.fire({
                        title: "Done",
                        icon: "success"
                    });
                    return true;
                }
                return false;
            }
        })
    }
    @if ($errors->has('name_org') || $errors->has('bio_org'))
        openReportUserForm();
    @endif
</script>
