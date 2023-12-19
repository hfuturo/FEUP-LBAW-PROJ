"use strict";

function openEditForm() {
    document.getElementById("edit_profile_popup").style.display = "block";
}

function closeEditForm() {
    document.getElementById("edit_profile_popup").style.display = "none";
}

function openDeleteForm() {
    document.getElementById("delete_account_popup").style.display = "block";
}

function closeDeleteForm() {
    document.getElementById("delete_account_popup").style.display = "none";
}

function openReportUserForm() {
    document.getElementById("report_user_popup").style.display = "block";
}

function closeReportUserForm() {
    document.getElementById("report_user_popup").style.display = "none";
}

function openEditPfpForm() {
    document.getElementById("edit_pfp_popup").style.display = "block";
}

function closeEditPfpForm() {
    document.getElementById("edit_pfp_popup").style.display = "none";
}

function openRemovePfpForm() {
    document.getElementById("remove_pfp_popup").style.display = "block";
}

function closeRemovePfpForm() {
    document.getElementById("remove_pfp_popup").style.display = "none";
}

function closeBlockForm() {
    document.getElementById("block_account_popup").style.display = "none";
}

function openBlockForm() {
    document.getElementById("block_account_popup").style.display = "block";
}

function openUnBlockForm() {
    document.getElementById("unblock_account_popup").style.display = "block";
}

function closeUnBlockForm() {
    document.getElementById("unblock_account_popup").style.display = "none";
}
const followButton = document.querySelector("#follow");
followButton?.addEventListener("click", () => {
    const user = document.querySelector("#following").value;
    sendAjaxRequest(
        "POST",
        `/api/profile/${followButton.dataset.operation}`,
        { user },
        followHandler
    );
});

document.querySelector("#submit_report")?.addEventListener("click", () => {
    const user = document.getElementById("reported").value;
    const reason = document.getElementById("reason").value;
    sendAjaxRequest(
        "POST",
        `/api/profile/report`,
        { user, reason },
        reportUserHandler
    );
});

function followHandler() {
    if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).follow;
    const count = document.querySelector("#folowers_count");
    const oldValue = parseInt(count.textContent.trim());
    const button = document.querySelector("#follow");
    button.dataset.operation = action;
    if (action == "follow") {
        count.textContent = oldValue - 1;
        button.querySelector("span").textContent = "person_add";
    } else {
        count.textContent = oldValue + 1;
        button.querySelector("span").textContent = "person_remove";
    }
    Swal.fire({
        icon: "success",
        title:
            "You " +
            (action === "follow" ? "unfollowed" : "followed") +
            " this user!",
        showConfirmButton: false,
        timer: 1500,
    });
}

function reportUserHandler() {
    if (this.status != 200) window.location = "/";
    closeReportUserForm();
    Swal.fire({
        icon: "success",
        title: "Thank you for reportin",
        text: "We will now analyse the situation.",
    });
}
