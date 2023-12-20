"use strict";

document.querySelector("#hamburger")?.addEventListener("click", (event) => {
    document
        .querySelector("main > nav")
        .classList.toggle("visivel", event.target.checked);
    document
        .querySelector("main > #content")
        .classList.toggle("visivel", event.target.checked);
});

setTimeout(() => {
    const sideNav = document.querySelector("main > nav");
    if (sideNav) {
        sideNav.style.minWidth =
            document.querySelector(".sticky_nav").getBoundingClientRect()
                .width + "px";
    }
}, 100);

document.querySelector("#hamburger")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        event.target.click();
    }
});

document.querySelector("#hamburger")?.addEventListener("click", (event) => {
    document.querySelector("main > nav").style.width = "0";
    if (event.target.checked) {
        document.querySelector("main > nav").style.minWidth = "0";
    } else {
        document.querySelector("main > nav").style.minWidth =
            document.querySelector(".sticky_nav").getBoundingClientRect()
                .width + "px";
    }
    document.querySelectorAll(".sticky_nav .button").forEach((elm) => {
        elm.tabIndex = event.target.checked ? -1 : 0;
    });
    const subOptions = document.getElementById("report_sub_options");
    subOptions.querySelectorAll(".button").forEach((elm) => {
        elm.tabIndex = subOptions.classList.contains("open") ? 0 : -1;
    });
});

const subOptions = document.getElementById("report_sub_options");
if (subOptions) {
    subOptions.querySelectorAll(".button").forEach((elm) => {
        elm.tabIndex = subOptions.classList.contains("open") ? 0 : -1;
    });
    document
        .getElementById("manage_report_button")
        .addEventListener("click", function () {
            subOptions.classList.toggle("open");
            subOptions.querySelectorAll(".button").forEach((elm) => {
                elm.tabIndex = subOptions.classList.contains("open") ? 0 : -1;
            });
            const buttonSpan = document
                .getElementById("manage_report_button")
                .querySelector("span");
            buttonSpan.textContent =
                buttonSpan.textContent === "expand_more"
                    ? "expand_less"
                    : "expand_more";
        });
}

function openTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "block";
}

function closeTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "none";
}

const createOrgForm = document.getElementById("create_org_popup");
function openNewOrg() {
    createOrgForm.style.display = "block";
}

function closeNewOrg() {
    createOrgForm.style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    if (document.querySelector("create_org_popup .input_error")) {
        openNewOrg();
    }
    if (document.querySelector("topic_proposal_popup .input_error")) {
        openTopicProposal();
    }
    if (document.querySelector("edit_profile_popup .input_error")) {
        openEditForm();
    }
});

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
