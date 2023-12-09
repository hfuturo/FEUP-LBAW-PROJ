"use strict";

document?.querySelectorAll(".vote_value").forEach((input) => {
    let value = input.value;
    let button
    if(value == 1) button = input.parentNode.querySelector(".remove")
    if(value == -1) button = input.parentNode.querySelector(".accept");
    button.style.backgroundColor = "grey";
    button.style.borderColor = "grey";
});

document.querySelectorAll(".vote").forEach((button) => {
    button.addEventListener("click", (event) => {
        let name = button.className;
        let content = button.parentNode.id;
        let method = "POST";
        let action, value;
        if(button.style.backgroundColor == "grey") action = "update";
        else {
            if(name == "vote accept") {
                console.log()
                if(button.parentNode.querySelector(".remove").style.backgroundColor == "grey"){
                    action = "destroy";
                    method = "DELETE";
                }
                else action = "create";
            }
            else {
                if(button.parentNode.querySelector(".accept").style.backgroundColor == "grey"){
                    action = "destroy";
                    method = "DELETE";
                }
                else action = "create";
            }
        }
        if(name == "vote accept") value = 1;
        if(name == "vote remove") value = -1;
        sendAjaxRequest(
            `${method}`,
            `/api/vote/${action}`,
            { content , value },
            voteHandler
        );
    });
});

function voteHandler() {
    if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).action;
    const vote = JSON.parse(this.responseText).vote;

    let selector = 'div.votes[id="' + JSON.parse(this.responseText).content + '"]';
    let element = document.querySelector(selector);
    let buttonUp = element.querySelector(".accept");
    let buttonDown = element.querySelector(".remove");

    if(action != "destroy" && vote == 1) {
        buttonDown.style.backgroundColor = "grey";
        buttonDown.style.borderColor = "grey";
        buttonUp.style.backgroundColor = "green";
        buttonUp.style.borderColor = "green";
    }
    else if(action != "destroy" && vote == -1) {
        buttonUp.style.backgroundColor = "grey";
        buttonUp.style.borderColor = "grey";
        buttonDown.style.backgroundColor = "red";
        buttonDown.style.borderColor = "red";
    }
    else {
        buttonUp.style.backgroundColor = "green";
        buttonUp.style.borderColor = "green";
        buttonDown.style.backgroundColor = "red";
        buttonDown.style.borderColor = "red";
    }
    if(action == "create") {
        if(vote == 1){
            const oldValue = parseInt(element.querySelector(".up_count").textContent.trim());
            element.querySelector(".up_count").textContent = oldValue + 1;
        }
        if(vote == -1){
            const oldValue = parseInt(element.querySelector(".down_count").textContent.trim());
            element.querySelector(".down_count").textContent = oldValue + 1;
        }
    }
    else if(action == "update") {
        const oldValueUp = parseInt(element.querySelector(".up_count").textContent.trim());
        const oldValueDown = parseInt(element.querySelector(".down_count").textContent.trim());
        if(vote == 1){
            element.querySelector(".up_count").textContent = oldValueUp + 1;
            element.querySelector(".down_count").textContent = oldValueDown - 1;
        }
        if(vote == -1){
            element.querySelector(".up_count").textContent = oldValueUp - 1;
            element.querySelector(".down_count").textContent = oldValueDown + 1;
        }
    }
    else if(action == "destroy") {
        if(vote == 1){
            const oldValue = parseInt(element.querySelector(".up_count").textContent.trim());
            element.querySelector(".up_count").textContent = oldValue - 1;
        }
        if(vote == -1){
            const oldValue = parseInt(element.querySelector(".down_count").textContent.trim());
            element.querySelector(".down_count").textContent = oldValue - 1;
        }
    }
}
