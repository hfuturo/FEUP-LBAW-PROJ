function openEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'block';
}
  
function closeEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'none';
}

document.querySelector('#follow').addEventListener('click', event => {
    const user =  document.querySelector('#following').value;
    sendAjaxRequest(
          'post',
          `/api/profile/${event.target.dataset.operation}`,
          {user},
          followHandler
    );
})
function followHandler() {
    if (this.status != 200) window.location = '/';
    const action = JSON.parse(this.responseText).follow;
    
    const count = document.querySelector('#folowers_count');
    const oldValue = parseInt(count.textContent.trim());
    const button = document.querySelector('#follow');
    button.dataset.operation = action;

    button.textContent = action;
    if(action=='follow') count.textContent = oldValue - 1;
    else count.textContent = oldValue + 1
}