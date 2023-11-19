@if (session('success'))
    <p class="success">
        {{ session('success') }}
    </p>
@endif
@if($errors->any())
    <p class="error">
        {{ $errors->first() }}
    </p>
@endif