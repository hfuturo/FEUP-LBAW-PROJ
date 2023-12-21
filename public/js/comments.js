"use strict";

// new comment
document
    .getElementById("commentForm")
    ?.addEventListener("submit", async function (event) {
        event.preventDefault();
        event.stopPropagation();
        const newsId = this.getAttribute("data-news-id");
        const link = `/news/${newsId}?page=1#comments`;
        const commentContent = document.getElementById("commentContent").value;

        try {
            const result = await fetch("/api/news/" + newsId + "/comment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: JSON.stringify({ content: commentContent }),
            }).then((response) => response.json());

            if (result.success) {
                const [response, raw_data] = await sendFetchRequest(
                    "GET",
                    link,
                    null,
                    "text"
                );
                updateComments(raw_data);
                history.pushState(null, "", link);
                document
                    .getElementById("comments")
                    .scrollIntoView({ behavior: "smooth" });

                document.getElementById("commentContent").value = "";
            } else {
                console.error("Failed to add comment");
                AlertMessage("Fail!", "Failed to add comment", "error");
            }
        } catch (error) {
            console.error("Error:", error);
            Swal.showValidationMessage(`
        Request failed: ${error}
        `);
        }
    });

function AlertMessage(title, text, icon) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
    });
}

function toggleMenu(button, event) {
    const dropdownSelect = button.nextElementSibling;
    document.querySelectorAll(".dropdown-content").forEach((dropdown) => {
        if (
            !dropdown.classList.contains("hidden") &&
            dropdown !== dropdownSelect
        ) {
            dropdown.classList.add("hidden");
        }
    });

    if (dropdownSelect) {
        event.stopPropagation();
        toggleDisplay(dropdownSelect);
    }
}

function toggleDisplay(element) {
    element.classList.toggle("hidden");
}

document.addEventListener("click", (event) => {
    event.preventDefault;
    const allDropdown = document.querySelectorAll(".dropdown-content");
    allDropdown.forEach((dropdown) => {
        if (!dropdown.classList.contains("hidden")) {
            dropdown.classList.add("hidden");
        }
    });
});

async function deleteCommentItem(button) {
    const comment = button.closest("article");
    const commentId = comment.getAttribute("comment-id");

    let currentURL = window.location.href;

    const result = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    });
    if (result.isConfirmed) {
        try {
            const data = await fetch(`/api/comment/${commentId}/delete`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
            }).then((response) => response.json());

            if (data.success) {
                /*
                const urlParams = new URLSearchParams(
                    currentURL.substring(currentURL.indexOf("?") + 1)
                );
                const pageNumber = urlParams.get("page");
                const section = comment.parentNode;

                if (pageNumber > 1 || pageNumber !== null) {
                    const commentPage = section.querySelectorAll("article");
                    const numberComments = commentPage.length;
                    if (numberComments === 1) {
                        urlParams.set("page", pageNumber - 1);
                        currentURL =
                            currentURL.split("?")[0] +
                            "?" +
                            urlParams.toString();
                        history.pushState(null, "", currentURL);
                    }
                }
                */
                const [response, raw_data] = await sendFetchRequest(
                    "GET",
                    currentURL,
                    null,
                    "text"
                );
                updateComments(raw_data);
                document
                    .getElementById("comments")
                    .scrollIntoView({ behavior: "smooth" });

                AlertMessage("Deleted!", data.success, "success");
            } else {
                AlertMessage("Fail!", data.error, "error");
            }
        } catch (error) {
            console.error("Error:", error);
            Swal.showValidationMessage(`
                Request failed: ${error}
              `);
        }
    }
}

function editCommentItem(button) {
    const comment = button.closest("article");
    const form = comment.querySelector(".editForm");
    const commentText = comment.querySelector(".comment_text");
    const textarea = comment.querySelector("textarea");
    textarea.value = commentText.textContent;
    form.addEventListener("submit", saveEdit);
    form.removeAttribute("hidden");
    commentText.setAttribute("hidden", "true");
}

async function saveEdit(event) {
    event.preventDefault();
    const comment = event.target.parentElement;
    const commentId = comment.getAttribute("comment-id");
    const commentContent = comment.querySelector(".commentContent").value;
    Swal.fire({
        title: "Are you sure you want to edit your comment?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const data = await fetch(
                    "/api/comment/" + commentId + "/edit",
                    {
                        method: "PATCH",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({ content: commentContent }),
                    }
                ).then((response) => response.json());

                const content = comment.querySelector(".comment_text");
                let editDate = comment.querySelector(".edit_date");

                if (data.success) {
                    if (editDate === null) {
                        const date = comment.querySelector(".date");
                        editDate = document.createElement("p");
                        editDate.className = "date edit_date";
                        date.insertAdjacentElement("afterend", editDate);
                    }
                    editDate.textContent = "Edited " + data.edit_date;
                    content.textContent = commentContent;
                    AlertMessage("Saved!", data.success, "success");
                } else {
                    AlertMessage("Fail!", data.error, "error");
                }
                editCancel(comment);
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`
                Request failed: ${error}
              `);
            }
        }
    });
}

function editCancel(comment) {
    const content = comment.querySelector(".comment_text");
    content.removeAttribute("hidden");

    const form = comment.querySelector(".editForm");
    form.setAttribute("hidden", "true");
}

function openReportCommentForm(button) {
    const comment = button.closest("article");
    const commentId = comment.getAttribute("comment-id");
    openReportContentForm(commentId);
}

async function submitReport(data) {
    const result = await Swal.fire({
        title: "Are you sure?",
        text: "Do you want to report this content?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, report it!",
    });
    if (result.isConfirmed) {
        try {
            const [response, message] = await sendFetchRequest(
                "POST",
                "/api/content/report/",
                data,
                "json"
            );
            if (message.success) {
                AlertMessage("Report made!", message.success, "success");
            } else {
                AlertMessage("Fail!", message.error, "error");
            }
        } catch (error) {
            console.error("Error:", error);
            Swal.showValidationMessage(`Request failed: ${error}`);
        }
    }
}

const commentSection = document.getElementById("comments");

document.querySelectorAll(".paginate a")?.forEach((link) => {
    link.addEventListener("click", feedLinksHandler);
});

async function feedLinksHandler(e) {
    e.preventDefault();
    e.stopPropagation();

    const link = e.target.closest("a");

    const [response, raw_data] = await sendFetchRequest(
        "GET",
        link.href,
        null,
        "text"
    );
    window.history.pushState(null, "", response.url);
    updateComments(raw_data);
    document.getElementById("comments").scrollIntoView({ behavior: "smooth" });
}

function updateComments(raw_data) {
    commentSection.innerHTML = raw_data;
    commentSection.querySelectorAll(".paginate a").forEach((link) => {
        link.addEventListener("click", feedLinksHandler);
    });
    addVoteEventListener();
}

window.addEventListener("popstate", (event) => {
    if (event.state) updateComments(event.state);
});
