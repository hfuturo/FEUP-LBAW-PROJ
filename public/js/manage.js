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
    const users = JSON.parse(this.responseText);

    let usersList = document.querySelector("#all_users");

    // limpa a lista
    usersList.innerHTML = "";

    // reconstroi lista
    for (const user of users) {
        let li = document.createElement("li");
        li.classList.add("user");
        li.setAttribute("id", user.id);
        let link = document.createElement("a");
        link.href = "/profile/" + user.id;
        link.innerHTML = user.name;
        let blockUnblockButton = document.createElement("button");
        blockUnblockButton.classList.add(user.blocked ? "unblock" : "block");
        // blockUnblockButton.setAttribute("data-operation", "block_user");
        let buttonSpan = document.createElement("span");
        buttonSpan.classList.add("material-symbols-outlined");
        buttonSpan.innerHTML = user.blocked ? "done_outline" : "block";
        blockUnblockButton.appendChild(buttonSpan);
        li.appendChild(link);
        li.appendChild(blockUnblockButton);
        usersList.appendChild(li);

        blockUnblockEventListener(
            buttonSpan,
            user.blocked ? "unblock" : "block"
        );
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
        const id = event.target.parentNode.parentNode.id;
        const name = icon.parentNode.previousElementSibling.textContent;
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
        const idUser = button.parentNode.id;
        sendAjaxRequest(
            "post",
            `/api/${event.target.dataset.operation}`,
            { idUser },
            upgradeUserHandler
        );
    });
});

function upgradeUserHandler() {
    if (this.status != 200) window.location = "/";
    let id = JSON.parse(this.responseText).id;
    let element = document.querySelector('li[id="' + id + '"] .upgrade');
    element.remove();
}
