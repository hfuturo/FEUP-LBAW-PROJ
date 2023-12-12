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
        let blockButton = document.createElement("button");
        blockButton.classList.add("block");
        blockButton.setAttribute("data-operation", "block_user");
        let buttonSpan = document.createElement("span");
        buttonSpan.classList.add("material-symbols-outlined");
        buttonSpan.innerHTML = "block";
        blockButton.appendChild(buttonSpan);
        li.appendChild(link);
        li.appendChild(blockButton);
        usersList.appendChild(li);

        addBlockEventListener(buttonSpan);
    }
}

document
    .querySelectorAll("#all_users .user button.block span")
    ?.forEach((icon) => {
        addBlockEventListener(icon);
    });

function addBlockEventListener(icon) {
    icon.addEventListener("click", async (event) => {
        const id = event.target.parentNode.parentNode.id;
        await fetch("/api/block_user", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ request: id }),
        }).then((response) => response.json());

        icon.innerHTML = "done_outline";

        const button = icon.parentNode;
        button.classList.remove("block");
        button.classList.add("unblock");
    });
}

document.querySelectorAll(".topics_proposal").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idTopic = button.id;
        sendAjaxRequest(
            "post",
            `/manage_topic/${event.target.dataset.operation}`,
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
