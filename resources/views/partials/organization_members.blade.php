<script>
    function openMembersOrg() {
        Swal.fire({
            title: "Members of the Organization!",
            html: `
            @foreach ($organization->members as $member)
                <div>
                    <h4>{{ $member->name }}</h4>
                    <p>Role: {{ $member->member_type }}<p>
                    <p>Date: {{ \Carbon\Carbon::parse($member->joined_date) }}<p>
                </div>
            @endforeach
            `,
            confirmButtonColor: 'var(--primary-color)',
            customClass: {
                confirmButton: "button",
            },
            buttonsStyling: false,
        }
    )}
</script>
