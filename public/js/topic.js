/* popup to topic proposal */
function openTopicProposal() {
    document.getElementById('topic_proposal_popup').style.display = 'block';
}
  
function closeTopicProposal() {
    document.getElementById('topic_proposal_popup').style.display = 'none';
}

document.querySelectorAll('.topics_proposal').forEach(button => {
    button.addEventListener('click', event => {
        const idTopic = button.id;
        sendAjaxRequest(
              'post',
              `/manage_topic/${event.target.dataset.operation}`,
              {idTopic},
              topicProposalHandler
        );
    })
})

function topicProposalHandler() {
    if (this.status != 200) window.location = '/'
    let idTopic = JSON.parse(this.responseText);
    let element = document.getElementById(idTopic);
    element.remove();

}