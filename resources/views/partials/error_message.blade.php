@if (session('success'))
    <script>
        Swal.fire({
            title: "Done",
            icon: "success"
        });
    </script>
@endif
@if ($errors->any())
    <script>
        Swal.fire({
            icon: "error",
            title: "{{ $errors->first() }}",
        });
    </script>
@endif
