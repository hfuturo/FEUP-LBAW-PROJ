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
    if (JSON.parse(this.responseText).success) {
        const status = JSON.parse(this.responseText).status;
        const button = document.querySelector("#status");
        if (status == "none") {
            button.dataset.operation = "create";
            button.textContent = "Ask to Join";
            if (
                JSON.parse(this.responseText).old_role === "member" ||
                JSON.parse(this.responseText).old_role === "leader"
            ) {
                const count = document.querySelector("#numberMembers");
                count.textContent = parseInt(count.textContent.trim()) - 1;
            }
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
            text: "Check if you have the right permissons or try to refresh the page.",
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
    closeRequestOrg();
    if (JSON.parse(this.responseText).success) {
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
            buttonAccept.classList.add("button", "manage", "expel");
            buttonAccept.setAttribute("data-operation", "expel");
            buttonAccept.textContent = "Upgrade";
            const buttonExpel = document.createElement("button");
            buttonExpel.classList.add("button", "manage", "upgrade");
            buttonExpel.setAttribute("data-operation", "upgrade");
            buttonExpel.textContent = "Expel";

            h4Element.appendChild(aElement);
            h4Element.appendChild(spanElement);

            sectionMember.appendChild(h4Element);
            sectionMember.appendChild(date);
            sectionMember.appendChild(buttonAccept);
            sectionMember.appendChild(buttonExpel);

            document
                .getElementById("manage_section")
                .appendChild(sectionMember);
        }
    } else {
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: "Check if you have the right permissons or try to refresh the page.",
        });
    }
}
