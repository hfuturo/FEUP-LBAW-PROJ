<script>
    function openReportContentForm(id) {
        Swal.fire({
            title: "Report",
            html: `
        <form id="report_form">
            @csrf
            <input type="hidden" id="id_content" name="id_content" value="${id}">
            <label for="reason">Reason *</label>
            <textarea id="reason" name="reason" placeholder="Reason for the report" required></textarea>
            @error('reason')
                <p class="report_error">{{ $message }}</p>
            @enderror
        </form><p>(fields with * are mandatory)</p>
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
                    submitReport(getFormParams(form));
                    return true;
                }
                return false;
            }
        })
    }
</script>
