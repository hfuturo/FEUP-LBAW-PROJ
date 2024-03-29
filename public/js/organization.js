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

document.querySelectorAll(".manage").forEach(addEventManageButton);
function addEventManageButton(button) {
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
}

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
            removeById(organizationRequests, user);
            openRequestOrg();
        } else if (action === "accept") {
            removeById(organizationRequests, user);
            openRequestOrg();

            const sectionMember = document.createElement("article");
            sectionMember.className = "info_article";
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
    } else {
        Swal.fire({
            icon: "error",
            title: "Something went wrong!",
            text: JSON.parse(this.responseText).message,
        });
    }
}
