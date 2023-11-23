function openEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'block';
}
  
function closeEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'none';
}


function follow(event){
    const user =  document.querySelector('#following').value;
    let button = event.target;
    let idButton = button.id;

    if(idButton === 'unfollow'){
        sendAjaxRequest('post','/api/profile/unfollow',{user: user},followHandler);
    }
    else if (idButton === 'follow'){
        sendAjaxRequest('post','/api/profile/follow',{user: user},followHandler);
    }
}

function followHandler() {
    if (this.status != 200) window.location = '/';
    const action = JSON.parse(this.responseText).follow;
    
    let elements = document.querySelectorAll('.user_info');
    elements.forEach(function(element) {

        let title = element.querySelector('h4');

        if (title && title.textContent.trim() === 'Followers') {

            let value = element.querySelector('p');
            let oldValue = parseInt(value.textContent.trim());
            let newValue;

            if(action === 'follow'){

                let button = document.getElementById('follow');
                button.id = 'unfollow';
                button.innerHTML = 'Unfollow';   
                newValue = oldValue + 1;
                value.textContent = newValue.toString();     
            }
            else if (action === 'unfollow') {
                let button = document.getElementById('unfollow');
                button.id = 'follow';
                button.innerHTML = 'Follow';
                newValue = oldValue - 1;
            }

            value.textContent = newValue.toString();

        }
    });
}