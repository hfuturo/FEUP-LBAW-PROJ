<script>
    function openTopicProposal() {
        Swal.fire({
            title: "Proporse a new topic!",
            html: `
<form method="post" action="{{ route('topic_proposal') }}">
    {{ csrf_field() }}

    <label for="name_topic">Name</label>
    <input class="form-item" id="name_topic" type="text" name="name_topic" placeholder="Name" required>
    @error('name_topic')
        <p class="new_topic_error">{{ $message }}</p>
    @enderror

    <label for="justification_topic">Justification</label>
    <input class="form-item" id="justification_topic" type="text" name="justification_topic" placeholder="Justification">
    @error('justification_topic')
        <p class="new_topic_error">{{ $message }}</p>
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
                popup.querySelector("form").submit()
            }
        })
    }
</script>
