<div id="remove_pfp_popup" class="popup">
    <div class="popup-content">
        <h3>Remove image</h3>
        <p> Are you sure you want to remove your image? </p>
        <span class="close" onclick="closeRemovePfpForm()">&times;</span>
            <form method="POST" action="/file/delete" enctype="multipart/form-data">
                @csrf
                <input name="type" type="text" value="profile" hidden>
                <button class="remove_pfp_image" type="submit">Remove image</button>
            </form>
    </div>
</div>

<button class="remove_pfp_image" onclick="openRemovePfpForm()">Remove image</button>