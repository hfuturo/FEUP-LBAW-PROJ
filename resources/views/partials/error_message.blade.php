@if (session('success'))
    <p class="success" onclick="this.style.display='none'">
        {{ session('success') }}
    </p>
@endif
@if ($errors->any())
    <p class="error" onclick="this.style.display='none'">
        {{ $errors->first() }}
    </p>
@endif
