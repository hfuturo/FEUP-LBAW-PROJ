function openEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'block';
}
  
function closeEditForm() {
    document.getElementById('edit_profile_popup').style.display = 'none';
}

function openReportUserForm() {
    document.getElementById('report_user_popup').style.display = 'block';
}
  
function closeReportUserForm() {
    document.getElementById('report_user_popup').style.display = 'none';
}

document.querySelector('#follow').addEventListener('click', event => {
    const user =  document.querySelector('#following').value;
    sendAjaxRequest(
          'POST',
          `/api/profile/${event.target.dataset.operation}`,
          {user},
          followHandler
    );
})

document.querySelector('#submit_report').addEventListener('click', event => {
    const user =  document.getElementById('reported').value;
    const reason = document.getElementById('reason').value;
    sendAjaxRequest(
          'POST',
          `/api/profile/report`,
          {user,reason},
          reportUserHandler
    );
})

function followHandler() {
    //if (this.status != 200) window.location = '/';
    const action = JSON.parse(this.responseText).follow;
    
    const count = document.querySelector('#folowers_count');
    const oldValue = parseInt(count.textContent.trim());
    const button = document.querySelector('#follow');
    button.dataset.operation = action;

    button.textContent = action;
    if(action=='follow') count.textContent = oldValue - 1;
    else count.textContent = oldValue + 1
}

function reportUserHandler() {
    if (this.status != 200) window.location = '/';
    closeReportUserForm();
}