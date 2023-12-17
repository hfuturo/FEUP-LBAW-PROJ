function openMembersOrg() {
    document.getElementById("members_org_popup").style.display = "block";
}

function closeMembersOrg() {
    document.getElementById("members_org_popup").style.display = "none";
}

document.querySelector("#follow")?.addEventListener("click", (event) => {
    const organization = document.querySelector("#org").value;
    sendAjaxRequest(
        "POST",
        `/api/organization/${event.target.dataset.operation}`,
        { organization },
        followHandler
    );
});

function followHandler() {
    if (this.status != 200) window.location = "/";
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
        timer: 1500,
    });
}

document.querySelector("#status")?.addEventListener("click", (event) => {
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ffa600",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes!",
    }).then((result) => {
        if (result.isConfirmed) {
            const organization = document.querySelector("#org").value;
            sendAjaxRequest(
                "POST",
                `/api/organization/status/${event.target.dataset.operation}`,
                { organization },
                statusHandler
            );
        }
    });
});

function statusHandler() {
    if (this.status != 200) window.location = "/";
    const status = JSON.parse(this.responseText).status;
    const button = document.querySelector("#status");
    if (status == "none") {
        button.dataset.operation = "create";
        button.textContent = "Ask to Join";
    } else if (status == "ask") {
        button.dataset.operation = "destroy";
        button.textContent = "Delete Request";
    } else if (status == "none_org") {
        Swal.fire({
            title: "You were the last member!",
            text: "This organization was eliminated so you will be redirect.",
            showConfirmButton: false,
            timer: 4000,
        });
        setTimeout(function () {
            window.location = "/";
        }, 3000);
    }
}

document.querySelectorAll(".manage").forEach((button) => {
    button.addEventListener("click", (event) => {
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ffa600",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
                const organization = document.querySelector("#org").value;
                const user = event.target.parentNode.parentNode.id;
                sendAjaxRequest(
                    "POST",
                    `/api/organization/manage/${event.target.dataset.operation}`,
                    { organization, user },
                    manageOrganizationHandler
                );
            }
        });
    });
});

function manageOrganizationHandler() {
    if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).action;
    const user = JSON.parse(this.responseText).user;
    const selector = 'article[id="' + user + '"]';
    let article = document.querySelector(selector);
    if (action === "upgrade") {
        article.querySelector(".upgrade").remove();
        article.querySelector(".expel").remove();
        article.querySelector(".role").textContent = "(leader)";
    } else if (action === "expel") {
        article.remove();
    }
}

function openEditForm() {
    document.getElementById("edit_profile_popup").style.display = "block";
}
function closeEditForm() {
    document.getElementById("edit_profile_popup").style.display = "none";
}

document
    .getElementById("editOrgForm")
    .addEventListener("submit", async function (event) {
        event.preventDefault();
        const orgId = this.getAttribute("data-org-id");
        const name = document.getElementById("name").value;
        const bio = document.getElementById("bio").value;
        sendAjaxRequest(
            "POST",
            `/api/organization/update`,
            { orgId, name, bio },
            editOrgHandler
        );
    });

function editOrgHandler() {
    const success = JSON.parse(this.responseText).success;
    console.log(JSON.parse(this.responseText).name);
    console.log(JSON.parse(this.responseText).bio);
    closeEditForm();
    if (success) {
        console.log(document.getElementById("bioDisplayed"));
        document.getElementById("bioDisplayed").textContent = JSON.parse(
            this.responseText
        ).bio;
        document.getElementById("nameDisplayed").textContent = JSON.parse(
            this.responseText
        ).name;
        Swal.fire({
            title: "Done",
            icon: "success",
        });
    } else {
        Swal.fire({
            icon: "Error",
            title: "Something went wrong! Please check if the parameters were valid.",
        });
    }
}
