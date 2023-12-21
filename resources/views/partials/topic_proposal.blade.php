<script>
    function openTopicProposal() {
        Swal.fire({
            title: "Propose a new topic!",
            html: `
<form method="post" action="{{ route('topic_proposal') }}">
    {{ csrf_field() }}

    <label for="name_topic">Name</label>
    <input class="form-item" id="name_topic" type="text" name="name_topic" placeholder="Name" required>
    @error('name_topic')
        <p class="input_error">{{ $message }}</p>
    @enderror

    <label for="justification_topic">Justification</label>
    <input class="form-item" id="justification_topic" type="text" name="justification_topic" placeholder="Justification">
    @error('justification_topic')
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
                    // Usar em vez do submit so se n te importa o resultado porque nao da reload a pagina
                    // sendFetchRequest(form.method, form.action, getFormParams(form))
                }
            }
        })
    }
    @if ($errors->has('justification_topic') || $errors->has('name_topic'))
        openTopicProposal();
    @endif
</script>
