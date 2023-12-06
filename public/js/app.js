function addEventListeners() {
  const filterUsersInput = document.querySelector('#users input')
  if (filterUsersInput) {
      filterUsersInput.addEventListener('input', async function() {
          sendAjaxRequest('post','/api/manage', {search: filterUsersInput.value}, filterUsersHandler)
      })
  }

  document.querySelectorAll('.feed_button').forEach(button => {
    button.addEventListener('click', feedLinksHandler)
  })

  document.querySelectorAll('.paginate a').forEach(link => {
    link.addEventListener('click', feedLinksHandler)
  })
}
  
function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

async function feedLinksHandler(e) {
  e.preventDefault();
  e.stopPropagation();
  const response = await fetch(e.target.href)
  const raw_data = await response.text()
  updateFeed(raw_data)
  document.getElementById('content').scrollIntoView({behavior: 'smooth'})
}

function updateFeed(raw_data) {
  let all_news = document.querySelector('.all_news')
  all_news.innerHTML = raw_data;
  document.querySelectorAll('.all_news .paginate a').forEach(link => {
    link.addEventListener('click', feedLinksHandler)
  })
  return;
}

function filterUsersHandler() {
    if (this.status != 200) window.location = '/'
    const users = JSON.parse(this.responseText)

    let usersList = document.querySelector('#all_users')
    
    // limpa a lista
    usersList.innerHTML = ''

    // reconstroi lista
    for (const user of users) {
        let li = document.createElement('li')
        li.classList.add('user')
        let link = document.createElement('a')
        link.href = "/profile/" + user.id
        link.innerHTML = user.name
        li.appendChild(link)
        usersList.appendChild(li)
    }
}

addEventListeners();


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
      const noComments = document.getElementById("no_comments");
      console.log(noComments);
      if(noComments) {noComments.remove();};
      const commentSection = document.getElementById('comments');
      const newComment = document.createElement('article');
      newComment.className = "comment";
      newComment.setAttribute("comment-id", data.id);

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

      const more = makeDropDown();

      commentHead.appendChild(commentAuth);
      commentHead.appendChild(commentDate);
      commentHead.appendChild(more);


      newComment.appendChild(commentHead);
      newComment.appendChild(commentText);
      
      const votes = document.createElement('div');
      votes.className = "votes";
      const like = document.createElement('button');
      like.className = "accept";
      const sibLike = document.createElement('span');
      sibLike.className = "material-symbols-outlined";
      sibLike.textContent = "thumb_up";
      const nLikes = document.createElement('p');
      like.appendChild(sibLike);
      nLikes.textContent = 0;

      const dislike = document.createElement('button');
      dislike.className = "remove";
      const sibDislike = document.createElement('span');
      sibDislike.className = "material-symbols-outlined";
      sibDislike.textContent = "thumb_down";
      dislike.appendChild(sibDislike);
      const nDislikes = document.createElement('p');
      nDislikes.textContent = 0;

      votes.appendChild(like);
      votes.appendChild(nLikes);
      votes.appendChild(dislike);
      votes.appendChild(nDislikes);
      newComment.appendChild(votes);

      commentSection.prepend(newComment);
      deleteComment();
      document.getElementById('commentContent').value = '';
  } else {
      console.error('Failed to add comment');
  }
});




function toggleDisplay(element) {
  if (element.style.display === "block") {
    element.style.display = "none";
  } else {
    element.style.display = "block";
  }
}

function toggleMenu(button) {
  const dropdown = button.nextElementSibling;
  if (dropdown) {
    toggleDisplay(dropdown);
  }
}



function deleteComment() {
  const comments = document.querySelectorAll('.comment');

  comments.forEach(function(comment) {
      const delComment = comment.querySelector('.delete');
      delComment.addEventListener('click', async function(event) {
          event.preventDefault();

          const commentId = comment.getAttribute('comment-id');
          try {
              const data = await fetch('/api/comment/' + commentId, {
                  method: 'DELETE',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                  },
              }).then(response=>response.json());

              const section = document.getElementById('comments');
              const message = document.createElement('p');

              if (data.success) {
                if(section.querySelectorAll('.comment').length === 1){
                  const noCommentsDiv = document.createElement('div');
                  const noComments = document.createElement('p');
                  noCommentsDiv.id = "no_comments";
                  noComments.textContent = "There are no comments yet";
                  noCommentsDiv.appendChild(noComments);
                  section.appendChild(noCommentsDiv);
                }
                message.className = 'success';
                message.textContent = data.success;
                comment.remove(); 
              } else {
                  message.className = 'error';
                  message.textContent = data.error;
              }
              section.prepend(message);
          } catch (error) {
              console.error('Error:', error);
          }
      });
  });
}

deleteComment();

function makeDropDown(){
  const options = [
    { icon: 'flag', label: 'Report' },
    { icon: 'delete', label: 'Delete', class: 'delete' },
    { icon: 'edit', label: 'Edit' }
  ];

  const dropdown = document.createElement('div');
  dropdown.className = "dropdown";

  const moreButton = document.createElement('button');
  moreButton.className = "more";
  moreButton.addEventListener('click', function() {
    toggleMenu(this);
  });

  const moreIcon = document.createElement('span');
  moreIcon.className = "material-symbols-outlined";
  moreIcon.textContent = "more_vert";

  moreButton.appendChild(moreIcon);

  const dropdownContent = document.createElement('div');
  dropdownContent.className = "dropdown-content";

  options.forEach(option =>{
    const optionDiv = document.createElement('div');
    optionDiv.className = "dropdown-option";

    const icon = document.createElement('span');
    icon.className = "material-symbols-outlined";
    icon.textContent = option.icon;

    const label = document.createElement('span');
    label.textContent = option.label;

    optionDiv.appendChild(icon);
    optionDiv.appendChild(label);

    if (option.class) {
      optionDiv.classList.add(option.class);
    }

    dropdownContent.appendChild(optionDiv);

  });

  dropdown.appendChild(moreButton);
  dropdown.appendChild(dropdownContent);

  return dropdown;
}