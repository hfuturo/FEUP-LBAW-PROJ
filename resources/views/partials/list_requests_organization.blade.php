<script>
    const organizationRequests = [
        @foreach ($organization->requests as $request)
            {
                id: {{ $request->id }},
                html: `
                <div class="requests" id="{{ $request->id }}">
                    <p>Name: {{ $request->name }}<p>
                    <p>Date: {{ \Carbon\Carbon::parse($request->joined_date) }}<p>
                    <button class="button manage" data-operation="accept">Accept</button>
                    <button class="button manage" data-operation="decline">Decline</button>
                </div>`
            },
        @endforeach
    ]

    function openRequestOrg() {
        Swal.fire({
            title: "New Requests",
            html: organizationRequests.length > 0 ? `${organizationRequests.map(req=>req.html).join("")}` :
                "<p>There are no requests to show.</p>",
            confirmButtonColor: 'var(--primary-color)',
            customClass: {
                confirmButton: "button",
            },
            buttonsStyling: false,
            confirmButtonText: 'Close',
            didOpen: () => {
                const popup = Swal.getPopup()
                popup.querySelectorAll(".manage").forEach(addEventManageButton);
            }
        })
    }
</script>
