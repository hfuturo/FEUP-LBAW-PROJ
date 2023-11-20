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
  
  document.querySelectorAll('.all_news .paginate a').forEach(link => {
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
  
/* popup to topic proposal */
function openTopicProposal() {
  document.getElementById('topic_proposal_popup').style.display = 'block';
}

function closeTopicProposal() {
  document.getElementById('topic_proposal_popup').style.display = 'none';
}

/* open profile edit form */
function openEditForm() {
  document.getElementById('edit_profile_popup').style.display = 'block';
}

function closeEditForm() {
  document.getElementById('edit_profile_popup').style.display = 'none';
}

addEventListeners();
