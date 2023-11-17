const filterUsersInput = document.querySelector('#users input')
if (filterUsersInput) {
    filterUsersInput.addEventListener('input', async function() {
        sendAjaxRequest('post','/api/manage', {search: filterUsersInput.value}, filterUsersHandler)
    })
}

function filterUsersHandler() {
    if (this.status != 200) console.log('error')
    const users = JSON.parse(this.responseText)

    let usersList = document.querySelector('#all_users')
    
    // limpa a lista
    usersList.innerHTML = ''

    // reconstroi lista
    for (const user of users) {
        let li = document.createElement('li')
        li.classList.add('user')
        let link = document.createElement('a')
        link.href = ""
        link.innerHTML = user.name
        li.appendChild(link)
        usersList.appendChild(li)
    }
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