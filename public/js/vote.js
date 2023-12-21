"use strict";

function addVoteInfo() {
    document?.querySelectorAll(".vote_value").forEach((input) => {
        let value = input.value;
        let button;
        if (value == 1) {
            button = input.parentNode.querySelector(".accept");
            button.style.backgroundColor = "green";
            button.style.borderColor = "green";
        }
        if (value == -1) {
            button = input.parentNode.querySelector(".remove");
            button.style.backgroundColor = "red";
            button.style.borderColor = "red";
        }
    });
}

function addVoteEventListener() {
    addVoteInfo();

    document.querySelectorAll(".vote").forEach((button) => {
        if (button.dataset.hasEvents) return;
        button.dataset.hasEvents = true;
        button.addEventListener("click", (event) => {
            let name = button.className;
            let content = button.parentNode.id;
            let method = "POST";
            let action, value;
            if (
                (name == "vote accept" &&
                    button.style.backgroundColor == "green") ||
                (name == "vote remove" && button.style.backgroundColor == "red")
            ) {
                action = "destroy";
                method = "DELETE";
            } else if (
                (name == "vote accept" &&
                    button.parentNode.querySelector(".remove").style
                        .backgroundColor == "red") ||
                (name == "vote remove" &&
                    button.parentNode.querySelector(".accept").style
                        .backgroundColor == "green")
            ) {
                action = "update";
                method = "POST";
            } else {
                action = "create";
                method = "POST";
            }

            if (name == "vote accept") value = 1;
            if (name == "vote remove") value = -1;

            sendAjaxRequest(
                `${method}`,
                `/api/vote/${action}`,
                { content, value },
                voteHandler
            );
        });
    });
}
addVoteEventListener();

function voteHandler() {
    //if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).action;
    const vote = JSON.parse(this.responseText).vote;

    let selector =
        'div.votes[id="' + JSON.parse(this.responseText).content + '"]';
    let element = document.querySelector(selector);
    let buttonUp = element.querySelector(".accept");
    let buttonDown = element.querySelector(".remove");

    if (action != "destroy" && vote == 1) {
        buttonDown.style.backgroundColor = "grey";
        buttonDown.style.borderColor = "grey";
        buttonUp.style.backgroundColor = "green";
        buttonUp.style.borderColor = "green";
    } else if (action != "destroy" && vote == -1) {
        buttonUp.style.backgroundColor = "grey";
        buttonUp.style.borderColor = "grey";
        buttonDown.style.backgroundColor = "red";
        buttonDown.style.borderColor = "red";
    } else {
        buttonUp.style.backgroundColor = "grey";
        buttonUp.style.borderColor = "grey";
        buttonDown.style.backgroundColor = "grey";
        buttonDown.style.borderColor = "grey";
    }
    if (action == "create") {
        if (vote == 1) {
            const oldValue = parseInt(
                element.querySelector(".up_count").textContent.trim()
            );
            element.querySelector(".up_count").textContent = oldValue + 1;
        }
        if (vote == -1) {
            const oldValue = parseInt(
                element.querySelector(".down_count").textContent.trim()
            );
            element.querySelector(".down_count").textContent = oldValue + 1;
        }
    } else if (action == "update") {
        const oldValueUp = parseInt(
            element.querySelector(".up_count").textContent.trim()
        );
        const oldValueDown = parseInt(
            element.querySelector(".down_count").textContent.trim()
        );
        if (vote == 1) {
            element.querySelector(".up_count").textContent = oldValueUp + 1;
            element.querySelector(".down_count").textContent = oldValueDown - 1;
        }
        if (vote == -1) {
            element.querySelector(".up_count").textContent = oldValueUp - 1;
            element.querySelector(".down_count").textContent = oldValueDown + 1;
        }
    } else if (action == "destroy") {
        if (vote == 1) {
            const oldValue = parseInt(
                element.querySelector(".up_count").textContent.trim()
            );
            element.querySelector(".up_count").textContent = oldValue - 1;
        }
        if (vote == -1) {
            const oldValue = parseInt(
                element.querySelector(".down_count").textContent.trim()
            );
            element.querySelector(".down_count").textContent = oldValue - 1;
        }
    }
}
