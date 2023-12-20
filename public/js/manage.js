"use strict";

const filterUsersInput = document.querySelector("#users input");

if (filterUsersInput) {
    filterUsersInput.addEventListener("input", async function () {
        sendAjaxRequest(
            "post",
            "/api/manage",
            { search: filterUsersInput.value },
            filterUsersHandler
        );
    });
}

function filterUsersHandler() {
    if (this.status != 200) window.location = "/";
    const data = JSON.parse(this.responseText);

    const users = data.users;
    const topics = data.topics;

    const usersList = document.querySelector("#all_users");

    // limpa a lista
    usersList.innerHTML = "";

    // reconstroi lista
    for (const user of users) {
        const li = document.createElement("li");
        li.classList.add("user");
        li.setAttribute("id", user.id);
        const buttonsDiv = document.createElement("div");
        const link = document.createElement("a");
        link.href = "/profile/" + user.id;
        link.innerHTML = user.name;
        const buttonSpan = document.createElement("span");
        if (parseInt(user_id) !== user.id) {
            const blockUnblockButton = document.createElement("button");
            blockUnblockButton.classList.add(
                user.blocked ? "unblock" : "block"
            );
            buttonSpan.classList.add("material-symbols-outlined");
            buttonSpan.innerHTML = user.blocked ? "done_outline" : "block";
            blockUnblockButton.appendChild(buttonSpan);
            buttonsDiv.appendChild(blockUnblockButton);
        }

        const linksDiv = document.createElement("div");
        linksDiv.appendChild(link);
        if (user.id_topic !== null) {
            const linkTopic = document.createElement("a");
            linkTopic.classList.add("is_mod");
            linkTopic.href = "/topic/" + user.id_topic;
            const n = user.id_topic;
            linkTopic.innerHTML = "Moderator of " + topics[n];
            linksDiv.appendChild(linkTopic);
        }

        const buttonMod = document.createElement("button");

        if (user.type !== "admin") {
            buttonMod.classList.add("text", "modBut", "button");
            if (!user.blocked && user.id_topic !== null) {
                buttonMod.addEventListener("click", function () {
                    revokeModerator(this);
                });
                buttonMod.textContent = "Revoke Moderator";
            }
            if (!user.blocked && user.id_topic === null) {
                buttonMod.addEventListener("click", function () {
                    openMakeModeratorTopic(this);
                });
                buttonMod.textContent = "Make Moderator";
            }

            const buttonAdmin = document.createElement("button");
            buttonAdmin.classList.add("upgrade", "button");
            buttonAdmin.setAttribute("data-operation", "upgrade_user");
            if (!user.blocked && user.type !== "admin") {
                buttonAdmin.addEventListener("click", function () {
                    const idUser = buttonAdmin.parentNode.parentNode.id;
                    sendAjaxRequest(
                        "post",
                        `/api/${buttonAdmin.dataset.operation}`,
                        { idUser },
                        upgradeUserHandler
                    );
                });
                buttonAdmin.textContent = "Upgrade to Administrator";
            }

            buttonsDiv.append(buttonMod, buttonAdmin);
        }

        li.append(linksDiv, buttonsDiv);

        usersList.appendChild(li);

        if (parseInt(user_id) !== user.id) {
            blockUnblockEventListener(
                buttonSpan,
                user.blocked ? "unblock" : "block"
            );
        }
    }
}

// block icon
document
    .querySelectorAll("#all_users .user button.block span")
    ?.forEach((icon) => {
        blockUnblockEventListener(icon, "block");
    });

// unblock icon
document
    .querySelectorAll("#all_users .user button.unblock span")
    ?.forEach((icon) => {
        blockUnblockEventListener(icon, "unblock");
    });

function blockUnblockEventListener(icon, action) {
    icon.addEventListener("click", async function eventHandler(event) {
        const method = action === "block" ? "block_user" : "unblock_user";
        const id = event.target.parentNode.parentNode.parentNode.id;
        const name =
            icon.parentNode.parentNode.previousElementSibling.textContent;
        Swal.fire({
            title: "Do you want to " + action + " " + name + "?",
            text:
                name +
                " will " +
                (action === "block" ? "lose" : "regain") +
                " access to the account.",
            showCancelButton: true,
            confirmButtonText: action.charAt(0).toUpperCase() + action.slice(1),
            icon: "question",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch("/api/" + method, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({ request: id }),
                    });

                    return response.json();
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: Try again later.`
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: name + " was " + action + "ed successfully",
                    icon: "success",
                });

                icon.innerHTML = action === "block" ? "done_outline" : "block";

                const button = icon.parentNode;
                button.classList.remove(
                    action === "block" ? "block" : "unblock"
                );
                button.classList.remove(
                    action === "block" ? "unblock" : "block"
                );

                // atualiza event listener
                icon.removeEventListener("click", eventHandler);
                blockUnblockEventListener(
                    icon,
                    action === "block" ? "unblock" : "block"
                );
            }
        });
    });
}

document.querySelectorAll(".topics_proposal").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idTopic = button.id;
        sendAjaxRequest(
            "post",
            `/manage_topic/${event.target.parentNode.dataset.operation}`,
            { idTopic },
            topicProposalHandler
        );
    });
});

function topicProposalHandler() {
    if (this.status != 200) window.location = "/";
    let idTopic = JSON.parse(this.responseText);
    let element = document.getElementById(idTopic);
    element.remove();
}

document.querySelectorAll(".upgrade").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idUser = button.parentNode.parentNode.id;
        sendAjaxRequest(
            "post",
            `/api/${event.target.dataset.operation}`,
            { idUser },
            upgradeUserHandler
        );
    });
});

function upgradeUserHandler() {
    //if (this.status != 200) window.location = "/";
    let id = JSON.parse(this.responseText).id;
    let element = document.querySelector('li[id="' + id + '"] .upgrade');
    element.remove();
}
