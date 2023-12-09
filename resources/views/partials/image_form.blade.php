<form method="POST" action="/file/upload" enctype="multipart/form-data">
    @csrf
    <input name="file" type="file" required>
    <input name="type" type="text" value="profile" hidden>
    <button type="submit">Submit</button>
</form>