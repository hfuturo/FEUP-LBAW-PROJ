function addEventListeners() {
    let itemCheckers = document.querySelectorAll('article.card li.item input[type=checkbox]');
    [].forEach.call(itemCheckers, function(checker) {
      checker.addEventListener('change', sendItemUpdateRequest);
    });
  
    let itemCreators = document.querySelectorAll('article.card form.new_item');
    [].forEach.call(itemCreators, function(creator) {
      creator.addEventListener('submit', sendCreateItemRequest);
    });
  
    let itemDeleters = document.querySelectorAll('article.card li a.delete');
    [].forEach.call(itemDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteItemRequest);
    });
  
    let cardDeleters = document.querySelectorAll('article.card header a.delete');
    [].forEach.call(cardDeleters, function(deleter) {
      deleter.addEventListener('click', sendDeleteCardRequest);
    });
  
    let cardCreator = document.querySelector('article.card form.new_card');
    if (cardCreator != null)
      cardCreator.addEventListener('submit', sendCreateCardRequest);

    const filterUsersInput = document.querySelector('#users input')
    if (filterUsersInput) {
        filterUsersInput.addEventListener('input', async function() {
            sendAjaxRequest('post','/api/manage', {search: filterUsersInput.value}, filterUsersHandler)
        })
    }

    const follow_feed = document.querySelector('.feed_button.follow_feed');
    if (follow_feed) {
      follow_feed.addEventListener('click', async function() {
            sendAjaxRequest('get', '/api/news/follow_feed', null, updateFeedHandler)
            updateButtonColor(follow_feed,recent_feed)
      })
    }

    const recent_feed = document.querySelector('.feed_button.recent_feed');
    if (recent_feed) {
      recent_feed.addEventListener('click', async function() {
            sendAjaxRequest('get', '/api/news/recent_feed', null, updateFeedHandler)
            updateButtonColor(recent_feed,follow_feed)
      })
    }
  }
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function updateButtonColor(button_clicked, button_reset) {
    button_clicked.style.background = '#606c76'
    button_clicked.style.border = '#606c76'
    button_reset.style.background = '#9b4dca'
    button_reset.style.border = '#9b4dca'
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
  console.log(raw_data.posts)
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

  let paginator = document.createElement('span')
  paginator.classList.add('paginate')
  paginator.innerHTML = raw_data.links
  all_news.appendChild(paginator)

  const links_num = document.querySelectorAll(".paginate .relative.z-0.inline-flex.shadow-sm.rounded-md a")
  const button_next_previous = document.querySelectorAll(".paginate nav[role='navigation'] > div:first-of-type a")
  feedLinksHandler(links_num)
  feedLinksHandler(button_next_previous)
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

  function sendItemUpdateRequest() {
    let item = this.closest('li.item');
    let id = item.getAttribute('data-id');
    let checked = item.querySelector('input[type=checkbox]').checked;
  
    sendAjaxRequest('post', '/api/item/' + id, {done: checked}, itemUpdatedHandler);
  }
  
  function sendDeleteItemRequest() {
    let id = this.closest('li.item').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/item/' + id, null, itemDeletedHandler);
  }
  
  function sendCreateItemRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
    let description = this.querySelector('input[name=description]').value;
  
    if (description != '')
      sendAjaxRequest('put', '/api/cards/' + id, {description: description}, itemAddedHandler);
  
    event.preventDefault();
  }
  
  function sendDeleteCardRequest(event) {
    let id = this.closest('article').getAttribute('data-id');
  
    sendAjaxRequest('delete', '/api/cards/' + id, null, cardDeletedHandler);
  }
  
  function sendCreateCardRequest(event) {
    let name = this.querySelector('input[name=name]').value;
  
    if (name != '')
      sendAjaxRequest('put', '/api/cards/', {name: name}, cardAddedHandler);
  
    event.preventDefault();
  }
  
  function itemUpdatedHandler() {
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    let input = element.querySelector('input[type=checkbox]');
    element.checked = item.done == "true";
  }
  
  function itemAddedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
  
    // Create the new item
    let new_item = createItem(item);
  
    // Insert the new item
    let card = document.querySelector('article.card[data-id="' + item.card_id + '"]');
    let form = card.querySelector('form.new_item');
    form.previousElementSibling.append(new_item);
  
    // Reset the new item form
    form.querySelector('[type=text]').value="";
  }
  
  function itemDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let item = JSON.parse(this.responseText);
    let element = document.querySelector('li.item[data-id="' + item.id + '"]');
    element.remove();
  }
  
  function cardDeletedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
    let article = document.querySelector('article.card[data-id="'+ card.id + '"]');
    article.remove();
  }
  
  function cardAddedHandler() {
    if (this.status != 200) window.location = '/';
    let card = JSON.parse(this.responseText);
  
    // Create the new card
    let new_card = createCard(card);
  
    // Reset the new card input
    let form = document.querySelector('article.card form.new_card');
    form.querySelector('[type=text]').value="";
  
    // Insert the new card
    let article = form.parentElement;
    let section = article.parentElement;
    section.insertBefore(new_card, article);
  
    // Focus on adding an item to the new card
    new_card.querySelector('[type=text]').focus();
  }
  
  function createCard(card) {
    let new_card = document.createElement('article');
    new_card.classList.add('card');
    new_card.setAttribute('data-id', card.id);
    new_card.innerHTML = `
  
    <header>
      <h2><a href="cards/${card.id}">${card.name}</a></h2>
      <a href="#" class="delete">&#10761;</a>
    </header>
    <ul></ul>
    <form class="new_item">
      <input name="description" type="text">
    </form>`;
  
    let creator = new_card.querySelector('form.new_item');
    creator.addEventListener('submit', sendCreateItemRequest);
  
    let deleter = new_card.querySelector('header a.delete');
    deleter.addEventListener('click', sendDeleteCardRequest);
  
    return new_card;
  }
  
  function createItem(item) {
    let new_item = document.createElement('li');
    new_item.classList.add('item');
    new_item.setAttribute('data-id', item.id);
    new_item.innerHTML = `
    <label>
      <input type="checkbox"> <span>${item.description}</span><a href="#" class="delete">&#10761;</a>
    </label>
    `;
  
    new_item.querySelector('input').addEventListener('change', sendItemUpdateRequest);
    new_item.querySelector('a.delete').addEventListener('click', sendDeleteItemRequest);
  
    return new_item;
  }
  
  addEventListeners();

/* popup to topic proposal */
function openTopicProposal() {
    document.getElementById('topic_proposal_popup').style.display = 'block';
}

function closeTopicProposal() {
    document.getElementById('topic_proposal_popup').style.display = 'none';
}