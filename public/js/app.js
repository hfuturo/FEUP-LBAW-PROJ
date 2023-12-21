"use strict";

document.querySelector("#hamburger")?.addEventListener("keypress", (event) => {
    if (event.key === "Enter") {
        event.target.click();
    }
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
