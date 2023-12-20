<div id="topic_proposal_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeTopicProposal()">&times;</span>
        <form method="post" action="{{ route('topic_proposal') }}">
            {{ csrf_field() }}

            <label for="name_topic">Name</label>
            <input id="name_topic" type="text" name="name" placeholder="Name" required>
            @error("name")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <label for="justification">Justification</label>
            <input id="justification" type="text" name="justification" placeholder="Justification">
            @error("justification")
                <p class="input_error">{{ $message }}</p>
            @enderror

            <button type="submit"> Submit </button>
        </form>
    </div>
</div>
