function openMembersOrg() {
    document.getElementById("members_org_popup").style.display = "block";
}

function closeMembersOrg() {
    document.getElementById("members_org_popup").style.display = "none";
}

document.querySelector("#follow")?.addEventListener("click", (event) => {
    const organization = document.querySelector("#following").value;
    sendAjaxRequest(
        "POST",
        `/api/organization/${event.target.dataset.operation}`,
        { organization },
        followHandler
    );
});

function followHandler() {
    //if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).follow;
    const button = document.querySelector("#follow");
    button.dataset.operation = action;
    if (action == "follow") {
        button.textContent = "Follow";
    } else {
        button.textContent = "Unfollow";
    }
    Swal.fire({
        icon: "success",
        title: "You " + action + " this organization!",
        showConfirmButton: false,
        timer: 1500
      });    
}