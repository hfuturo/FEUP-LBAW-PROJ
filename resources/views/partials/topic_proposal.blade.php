<div id="topic_proposal_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeTopicProposal()">&times;</span>
        <form method="post" action="{{ route('topic_proposal') }}">
            {{ csrf_field() }}

            <label for="name_topic">Name</label>
            <input id="name_topic" type="text" name="name_topic" placeholder="Name" required>
            @error("name_topic")
                <p class="new_topic_error">{{ $message }}</p>
            @enderror

            <label for="justification_topic">Justification</label>
            <input id="justification_topic" type="text" name="justification_topic" placeholder="Justification">
            @error("justification_topic")
                <p class="new_topic_error">{{ $message }}</p>
            @enderror

            <button type="submit"> Submit </button>
        </form>
    </div>
</div>
