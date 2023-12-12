"use strict";

document.querySelector("#notification_icon")?.addEventListener("click", (event) => {
    let lista = document.getElementById("notifications_pop_up");
    lista.style.display = lista.style.display === "block" ? "none" : "block";

});

document
    .getElementById("manage_report_button")
    .addEventListener("click", function () {
        let subOptions = document.getElementById("report_sub_options");
        subOptions.style.display =
            subOptions.style.display === "block" ? "none" : "block";
        let buttonSpan = document
            .getElementById("manage_report_button")
            .querySelector("span");
        buttonSpan.textContent =
            buttonSpan.textContent === "expand_more"
                ? "expand_less"
                : "expand_more";
    });

function openTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "block";
}

function closeTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "none";
}

function toggleDisplay(element) {
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}

document.addEventListener("click", (event) => {
    event.preventDefault;
    const allDropdown = document.querySelectorAll(".dropdown-content");
    allDropdown.forEach((dropdown) => {
        if (dropdown.style.display === "block") {
            dropdown.style.display = "none";
        }
    });
});

function cleanUpMessages() {
    document.querySelectorAll("p.success").forEach((message) => {
        if (getComputedStyle(message).display == "none") {
            message.remove();
        }
    });
}
setInterval(cleanUpMessages, 1000);
