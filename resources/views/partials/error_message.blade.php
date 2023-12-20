@if (session('success'))
    <script>
        Swal.fire({
            title: "Done",
            icon: "success"
        });
    </script>
@endif
@error("error")
<script>
    Swal.fire({
        icon: "error",
        title: "{{ $message }}",
    });
</script>
@enderror
