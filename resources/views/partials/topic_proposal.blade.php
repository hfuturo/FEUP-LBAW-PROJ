<div id="topic_proposal_popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeTopicProposal()">&times;</span>
        <form method="post" action="{{ route('topic_proposal') }}">
            {{ csrf_field() }}

            <label for="name">Name</label>
            <input id="name" type="text" name="name" required autofocus>

            <label for="justification" >Justification</label>
            <input id="justification" type="text" name="justification">

            <button type="submit"> Submit </button>

        </form>
    </div>
</div>

<a class="button" onclick="openTopicProposal()">Propose New Topic</a>