"use strict";

document
    .getElementById("manage_report_button")
    .addEventListener("click", function () {
        let subOptions = document.getElementById("report_sub_options");
        subOptions.style.display =
            subOptions.style.display === "block" ? "none" : "block";
    });

function openTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "block";
}

function closeTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "none";
}

document.querySelectorAll(".topics_proposal").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idTopic = button.id;
        sendAjaxRequest(
            "post",
            `/manage_topic/${event.target.dataset.operation}`,
            { idTopic },
            topicProposalHandler
        );
    });
});

function topicProposalHandler() {
    if (this.status != 200) window.location = "/";
    let idTopic = JSON.parse(this.responseText);
    let element = document.getElementById(idTopic);
    element.remove();
}


// new comment

document.getElementById('commentForm').addEventListener('submit', async function(event) {
  event.preventDefault();

  const newsId = this.getAttribute('data-news-id');
  const commentContent = document.getElementById('commentContent').value;

  const data = await fetch('/api/news/' + newsId + '/comment', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({content: commentContent})
  }).then(response=>response.json())

  if (data.success) {          
      const noComments = document.getElementById('no_comments');
      if(noComments) {noComments.remove();}

      const commentSection = document.getElementById('comments');
      const newComment = document.createElement('article');
      newComment.className = "comment";

      const commentHead = document.createElement('div');
      commentHead.className = "comment_header";

      const commentAuth = document.createElement('a');
      commentAuth.className = "comment_author";
      commentAuth.textContent = data.author.name;

      const commentDate = document.createElement('p');
      commentDate.className = "date";
      commentDate.textContent = data.date;

      const commentText = document.createElement('p');
      commentText.className = "comment_text";
      commentText.textContent= data.content;
      
      commentHead.appendChild(commentAuth);
      commentHead.appendChild(commentDate);
      newComment.appendChild(commentHead);
      newComment.appendChild(commentText);
      
      const votes = document.createElement('div');
      votes.className = "votes";

      
      const like = createLikeDislick("accept", "thumb_up");
      const nLikes = document.createElement('p');
      nLikes.textContent = 0;

      const dislike = createLikeDislick("remove", "thumb_down");
      const nDislikes = document.createElement('p');
      nDislikes.textContent = 0;
  
      votes.appendChild(like);
      votes.appendChild(nLikes);
      votes.appendChild(dislike);
      votes.appendChild(nDislikes);
      newComment.appendChild(votes);

      commentSection.prepend(newComment);
      document.getElementById('commentContent').value = '';
  } else {
      console.error('Failed to add comment');
  }
});

function createLikeDislick(className, symbol) {
  const button = document.createElement('button');
  button.className = className;
  
  const icon = document.createElement('span');
  icon.className = "material-symbols-outlined";
  icon.textContent = symbol;
  
  button.appendChild(icon);
  
  return button;
}
