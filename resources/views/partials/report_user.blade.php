<button onclick="openReportUserForm()">Report</button>
<script>
    function openReportUserForm() {
        Swal.fire({
            title: "Report",
            html: `
            <form method="POST" action="{{ route('create_user_report') }}">
                {{ csrf_field() }}
                <input type="hidden" id="reported" name="id_reported" value="{{ $user->id }}">
                <label for="reason">Reason</label>
                <textarea id="reason" name="reason" required></textarea>
                @error("reason")
                    <p class="input_error">{{ $message }}</p>
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
                    form.submit()
                    return true;
                }
                return false;
            }
        })
    }
    @if ($errors->has('reason'))
        openReportUserForm();
    @endif
</script>
