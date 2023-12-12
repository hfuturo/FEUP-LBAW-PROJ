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
    }
}

document.querySelectorAll(".block").forEach((button) => {
    button.addEventListener("click", (event) => {
        const request = event.target.parentNode.id;
        sendAjaxRequest(
            "POST",
            `/api/${event.target.dataset.operation}`,
            { request },
            blockHandler
        );
    });
});

function blockHandler() {
    if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).action;
    let selector = 'li[id="' + JSON.parse(this.responseText).id + '"] .block';
    const button = document.querySelector(selector);
    console.log(button);
    console.log;
    if (action == "block_user") {
        button.dataset.operation = "unblock_user";
        button.textContent = "Unblock";
    } else {
        button.dataset.operation = "block_user";
        button.textContent = "Block";
    }
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
