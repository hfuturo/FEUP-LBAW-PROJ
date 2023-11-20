function addEventListeners() {
  const filterUsersInput = document.querySelector('#users input')
  if (filterUsersInput) {
      filterUsersInput.addEventListener('input', async function() {
          sendAjaxRequest('post','/api/manage', {search: filterUsersInput.value}, filterUsersHandler)
      })
  }

  const top_feed = document.querySelector('.feed_button.top_feed');

  const follow_feed = document.querySelector('.feed_button.follow_feed');
  if (follow_feed) {
    follow_feed.addEventListener('click', async function() {
          sendAjaxRequest('get', '/api/news/follow_feed', null, updateFeedHandler)
          updateButtonColor(follow_feed,recent_feed,top_feed)
    })
  }

  const recent_feed = document.querySelector('.feed_button.recent_feed');
  if (recent_feed) {
    recent_feed.addEventListener('click', async function() {
          sendAjaxRequest('get', '/api/news/recent_feed', null, updateFeedHandler)
          updateButtonColor(recent_feed,follow_feed,top_feed)
    })
  }
}
  
function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function updateButtonColor(button_clicked, button_reset, button_reset2) {
  button_clicked.style.background = '#606c76'
  button_clicked.style.border = '#606c76'
  button_reset.style.background = '#9b4dca'
  button_reset.style.border = '#9b4dca'
  button_reset2.style.background = '#9b4dca'
  button_reset2.style.border = '#9b4dca'
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

function updateFeedHandler() {
  if (this.status != 200) window.location = '/'
  const raw_data = JSON.parse(this.responseText)
  updateFeed(raw_data)
}

async function feedLinksHandler(links) {
  for (let link of links) {
    const fetch_link = link.href
    link.removeAttribute("href")  // necessario para quando clicarmos não recarregar a pagina e ir para o feed default
    link.addEventListener('click', async function() {
      const response = await fetch(fetch_link)
      const raw_data = await response.json()
      updateFeed(raw_data)
      document.getElementById('content').scrollIntoView({behavior: 'smooth'})
    }) 
  }
}

function updateFeed(raw_data) {
  const posts = raw_data.posts.data
  let all_news = document.querySelector('.all_news')

  all_news.innerHTML = ''

  if (posts.length === 0) {
    let h2 = document.createElement('h2')
    h2.innerHTML = "None of the users you follow have posted."
    all_news.appendChild(h2)
    return;
  }
  

  for (const news of posts) {
    let time_elapsed = handleTimeAgo(news)
    let link = document.createElement('a')
    link.href = "/news/" + news.id
    let article = document.createElement('article')
    article.classList.add('user_news')
    let header = document.createElement('header')
    header.classList.add('news_header_feed')
    let title = document.createElement('h4')
    title.classList.add('news_title')
    title.innerHTML = news.title
    let time = document.createElement('h4')
    time.innerHTML = time_elapsed
    let p = document.createElement('p')
    p.classList.add('news_content')
    p.innerHTML = news.content
    header.appendChild(title)
    header.appendChild(time)
    article.appendChild(header)
    article.appendChild(p)
    link.appendChild(article)
    all_news.appendChild(link)
  }

  let paginator = document.createElement('span')
  paginator.classList.add('paginate')
  paginator.innerHTML = raw_data.links
  all_news.appendChild(paginator)

  const links_num = document.querySelectorAll(".paginate .relative.z-0.inline-flex.shadow-sm.rounded-md a")
  const button_next_previous = document.querySelectorAll(".paginate nav[role='navigation'] > div:first-of-type a")
  feedLinksHandler(links_num)
  feedLinksHandler(button_next_previous)
}

function handleTimeAgo(news) {
  if (news.years > 0) {
    return news.years === 1 ? "1 year ago" : news.years + " years ago";
  }
  
  if (news.months > 0) {
    return news.months === 1 ? "1 month ago" : news.months + " months ago";
  }

  if (news.weeks > 0) {
    return news.weeks === 1 ? "1 week ago" : news.weeks + " weeks ago";
  }

  if (news.days > 0) {
    return news.days === 1 ? "1 day ago" : news.days + " days ago";
  }

  if (news.hours > 0) {
    return news.hours === 1 ? "1 hour ago" : news.hours + " hours ago";
  }

  if (news.minutes > 0) {
    return news.minutes === 1 ? "1 minute ago" : news.minutes + " minutes ago";
  }

  if (news.seconds > 0) {
    return news.seconds === 1 ? "1 second ago" : news.seconds + " seconds ago";
  }
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