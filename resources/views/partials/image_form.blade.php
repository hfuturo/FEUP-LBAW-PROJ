<div id="edit_pfp_popup" class="popup">
    <div class="popup-content">
        <h3>Edit image</h3>
        <span class="close" onclick="closeEditPfpForm()">&times;</span>
            <form method="POST" action="/file/upload" enctype="multipart/form-data">
                @csrf
                <input name="file" type="file" required>
                <input name="type" type="text" value="profile" hidden>
                <button type="submit">Submit</button>
            </form>
    </div>
</div>

<button onclick="openEditPfpForm()">Edit Image</button>