"use strict";

document.querySelectorAll(".action_report").forEach((button) => {
    button.addEventListener("click", (event) => {
        let action = event.target.dataset.operation;
        let method, request;
        if (
            action == "delete_user" ||
            action == "delete_news_item" ||
            action == "delete_comment"
        ) {
            request = event.target.parentNode.parentNode
                .querySelector("h4")
                .getAttribute("class");
            method = "DELETE";
        }
        if (action == "delete_report") {
            request = event.target.parentNode.parentNode.id;
            method = "DELETE";
        }
        if (action == "block_user") {
            request = event.target.parentNode.parentNode
                .querySelector("h4")
                .getAttribute("class");
            method = "POST";
        }
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
                sendAjaxRequest(
                    `${method}`,
                    `/api/${action}`,
                    { request },
                    reportHandler
                );
            }
        });
    });
});

function reportHandler() {
    //if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).action;
    if (
        action == "delete_news_item" ||
        action == "delete_user" ||
        action == "delete_comment"
    ) {
        let selector = 'h4[class="' + JSON.parse(this.responseText).id + '"]';
        let elements = document.querySelectorAll(selector);
        elements.forEach(function (element) {
            element.parentNode.remove();
        });
    }
    if (action == "delete_report") {
        let selector = 'article[id="' + JSON.parse(this.responseText).id + '"]';
        let element = document.querySelector(selector);
        element.remove();
    }
    if (action == "block_user") {
        let selector =
            'article h4[class="' + JSON.parse(this.responseText).id + '"]';
        let elements = document.querySelectorAll(selector);
        elements.forEach(function (element) {
            element.textContent += "(this user is blocked)";
            element.parentNode
                .querySelector("[data-operation=block_user]")
                .remove();
        });
    }
    let mainElement = document.querySelector("#list_reports");
    if (mainElement.children.length <= 2) {
        let p = document.createElement("p");
        p.textContent = "There are no reports to show.";
        mainElement.appendChild(p);
    }
}
