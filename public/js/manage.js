const filterUsersInput = document.querySelector('#users input')
if (filterUsersInput) {
    filterUsersInput.addEventListener('input', async function() {
        const response = await fetch('../api/manage?search=' + filterUsersInput.value)
        const users = await response.json()
    
        let usersList = document.querySelector('#all_users')
    
        // limpa a lista
        usersList.innerHTML = ''
        console.log(users)
        for (const user of users) {
            let li = document.createElement('li')
            li.classList.add('user')
            let link = document.createElement('a')
            link.href = ""
            link.innerHTML = user.name
            li.appendChild(link)
            usersList.appendChild(li)
        }
    })
}