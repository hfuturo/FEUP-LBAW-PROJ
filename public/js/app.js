"use strict";

document
    .getElementById("manage_report_button")
    .addEventListener("click", function () {
        let subOptions = document.getElementById("report_sub_options");
        subOptions.style.display =
            subOptions.style.display === "block" ? "none" : "block";
    });
