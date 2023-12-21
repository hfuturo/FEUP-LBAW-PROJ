function openMembersOrg() {
    document.getElementById("members_org_popup").style.display = "block";
}

function closeMembersOrg() {
    document.getElementById("members_org_popup").style.display = "none";
}

function openRequestOrg() {
    document.getElementById("request_org_popup").style.display = "block";
}

function closeRequestOrg() {
    document.getElementById("request_org_popup").style.display = "none";
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
    console.log(JSON.parse(this.responseText).success);
    console.log(JSON.parse(this.responseText).status);
    if (JSON.parse(this.responseText).success) {
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
    } else {
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: JSON.parse(this.responseText).message,
        });
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
    let success = JSON.parse(this.responseText).success;
    if (success === 1) {
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
        } else if (action === "decline") {
            const selector2 = '.popup-content div[id="' + user + '"]';
            let element = document.querySelector(selector2);
            element.remove();
        } else if (action === "accept") {
            const selector2 = '.popup-content div[id="' + user + '"]';
            let element = document.querySelector(selector2);
            element.remove();

            const sectionMember = document.createElement("article");
            sectionMember.className = "user_news";
            sectionMember.id = user;

            const aElement = document.createElement("a");
            aElement.textContent = JSON.parse(this.responseText).user_name;
            const spanElement = document.createElement("span");
            spanElement.className = "role";
            spanElement.textContent = "(member)";

            const h4Element = document.createElement("h4");

            const date = document.createElement("p");
            date.textContent = "Since: Now";

            const buttonAccept = document.createElement("button");
            buttonAccept.classList.add("button", "manage", "upgrade");
            buttonAccept.setAttribute("data-operation", "upgrade");
            buttonAccept.textContent = "Upgrade";
            const buttonExpel = document.createElement("button");
            buttonExpel.classList.add("button", "manage", "expel");
            buttonExpel.setAttribute("data-operation", "expel");
            buttonExpel.textContent = "Expel";

            h4Element.appendChild(aElement);
            h4Element.appendChild(spanElement);

            let divContainer = document.createElement("div");
            divContainer.appendChild(buttonExpel);
            divContainer.appendChild(buttonAccept);

            sectionMember.appendChild(h4Element);
            sectionMember.appendChild(date);
            sectionMember.appendChild(divContainer);
            document
                .getElementById("manage_section")
                .appendChild(sectionMember);

            buttonAccept.addEventListener("click", () => {
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffa600",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const organization =
                            document.querySelector("#org").value;
                        const user = buttonAccept.parentNode.parentNode.id;
                        console.log(user);
                        sendAjaxRequest(
                            "POST",
                            `/api/organization/manage/${buttonAccept.dataset.operation}`,
                            { organization, user },
                            manageOrganizationHandler
                        );
                    }
                });
            });

            buttonExpel.addEventListener("click", () => {
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ffa600",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        const organization =
                            document.querySelector("#org").value;
                        const user = buttonExpel.parentNode.parentNode.id;
                        console.log(user);
                        sendAjaxRequest(
                            "POST",
                            `/api/organization/manage/${buttonExpel.dataset.operation}`,
                            { organization, user },
                            manageOrganizationHandler
                        );
                    }
                });
            });
        }

        let container =
            document.querySelector("#request_org_popup").firstElementChild;
        console.log(container);
        if (container.childElementCount === 2) {
            let par = document.createElement("p");
            par.textContent = "There are no requests to show.";
            container.appendChild(par);
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: JSON.parse(this.responseText).message,
        });
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
