"use strict";

function openEditPfpForm() {
    document.getElementById("edit_pfp_popup").style.display = "block";
}

function closeEditPfpForm() {
    document.getElementById("edit_pfp_popup").style.display = "none";
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

const profileId = document.querySelector(
    "#content > div.user_page > div.profile"
)?.id;
const profileName = document.querySelector(
    "#user_card > div.user_follow_edit > h2"
).textContent;

// popup delete account button
document
    .querySelector("div.action_buttons_wrapper > button.delete_user_button")
    ?.addEventListener("click", () => {
        Swal.fire({
            title:
                "Are you sure you want to delete " +
                (user_id === profileId ? "your" : profileName + "'s ") +
                " account?",
            text: "You won't be able to revert this!",
            showCancelButton: true,
            showDenyButton: true,
            denyButtonText: "Delete",
            showConfirmButton: false,
            icon: "warning",
            showLoaderOnDeny: true,
            preDeny: async () => {
                try {
                    await sendFetchRequest("DELETE", "/api/delete_user", {
                        request: profileId,
                    });
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: Try again later. ${error}`
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isDenied) {
                Swal.fire({
                    title: "User deleted successfully.",
                    confirmButtonColor: "#3085d6",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                }).then((response) => {
                    if (response.isConfirmed) {
                        window.location.replace("/news");
                    }
                });
            }
        });
    });

// popup block user button
const blockButtonProfile = document.querySelector(
    "div.action_buttons_wrapper > button.block_user_button"
);
if (blockButtonProfile) {
    blockUnblockEventListenerProfile(blockButtonProfile, "block");
}

// popup unblock user button
const unblockButtonProfile = document.querySelector(
    "div.action_buttons_wrapper > button.unblock_user_button"
);
if (unblockButtonProfile) {
    blockUnblockEventListenerProfile(unblockButtonProfile, "unblock");
}

function blockUnblockEventListenerProfile(button, action) {
    button.addEventListener("click", async function eventHandler() {
        const method = action === "block" ? "block_user" : "unblock_user";
        Swal.fire({
            title: "Do you want to " + action + " " + profileName + "?",
            text:
                profileName +
                " will " +
                (action === "block" ? "lose" : "regain") +
                " access to the account.",
            showCancelButton: true,
            confirmButtonText: action.charAt(0).toUpperCase() + action.slice(1),
            icon: "question",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    await sendFetchRequest("POST", "/api/" + method, {
                        request: profileId,
                    });
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: Try again later.`
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: profileName + " was " + action + "ed successfully",
                    icon: "success",
                });

                button.innerHTML =
                    action === "block" ? "Unblock Account" : "Block Account";

                button.classList.remove(
                    action === "block"
                        ? "unblock_user_button"
                        : "block_user_button"
                );
                button.classList.add(
                    action === "unblock"
                        ? "block_user_button"
                        : "unblock_user_button"
                );

                // atualiza event listener
                button.removeEventListener("click", eventHandler);
                blockUnblockEventListenerProfile(
                    button,
                    action === "block" ? "unblock" : "block"
                );
            }
        });
    });
}

// remove pfp
document
    .querySelector(
        ".profile > .image_wrapper > .image_buttons_wrapper > .remove_pfp_image"
    )
    ?.addEventListener("click", () => {
        Swal.fire({
            title: "Remove image",
            text: "Are you sure you want to remove your profile picture?",
            showCancelButton: true,
            icon: "question",
            showLoaderOnConfirm: true,
        }).then(async (response) => {
            if (response.isConfirmed) {
                let data;
                try {
                    data = await sendFetchRequest(
                        "POST",
                        "/api/file/delete",
                        {
                            type: "profile",
                        },
                        "json"
                    );
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: Try again later.`
                    );
                }
                if (!data[1].success) {
                    Swal.fire({
                        title: "Error",
                        text: data[1].message,
                        icon: "error",
                    });
                } else {
                    // da reload para dar update a pfp e mostra popup
                    sessionStorage.setItem("reload-updated-pfp", "true");
                    location.reload();
                }
            }
        });
    });

// mostra popup quando pagina e recarregada depois do user mudar a pfp
window.onload = () => {
    const reload = sessionStorage.getItem("reload-updated-pfp");
    if (reload) {
        sessionStorage.removeItem("reload-updated-pfp");
        Swal.fire({
            title: "Success",
            text: "Profile picture removed successfully.",
            icon: "success",
        });
    }
};
