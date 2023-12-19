"use strict";

// new comment
document
    .getElementById("commentForm")
    ?.addEventListener("submit", async function (event) {
        event.preventDefault();

        const newsId = this.getAttribute("data-news-id");
        const commentContent = document.getElementById("commentContent").value;

        const data = await fetch("/api/news/" + newsId + "/comment", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ content: commentContent }),
        }).then((response) => response.json());

        if (data.success) {
            const noComments = document.getElementById("no_comments");

            if (noComments) {
                noComments.remove();
            }
            const commentSection = document.getElementById("comments");
            const newComment = document.createElement("article");
            newComment.className = "comment";
            newComment.setAttribute("comment-id", data.id);

            const commentHead = document.createElement("div");
            commentHead.className = "comment_header";

            const author_image = await fetch(
                "/api/fetch_pfp/" + data.author.id,
                {
                    method: "GET",
                }
            ).then((response) => response.json());

            const commentAuthorPfp = document.createElement("img");
            commentAuthorPfp.className = "author_comment_pfp";
            commentAuthorPfp.setAttribute("src", author_image.image);

            const commentAuth = document.createElement("a");
            commentAuth.className = "comment_author";
            commentAuth.textContent = data.author.name;

            const commentDate = document.createElement("p");
            commentDate.className = "date";
            commentDate.textContent = data.date;

            const commentText = document.createElement("p");
            commentText.className = "comment_text";
            commentText.textContent = data.content;

            const form = makeEditForm(data.content, newComment);

            const more = makeDropDown(newComment);

            commentHead.appendChild(commentAuthorPfp);
            commentHead.appendChild(commentAuth);
            if (data.news_author) {
                const authrIcon = document.createElement("span");
                authrIcon.className = "material-symbols-outlined author";
                authrIcon.textContent = "person_edit";
                commentHead.appendChild(authrIcon);
            }
            commentHead.appendChild(commentDate);
            commentHead.appendChild(more);

            newComment.appendChild(commentHead);
            newComment.append(form);
            newComment.appendChild(commentText);

            const votes = document.createElement("div");
            votes.className = "votes";

            const like = createLikeDislike("accept", "thumb_up", "up_count");
            const dislike = createLikeDislike(
                "remove",
                "thumb_down",
                "down_count"
            );

            votes.appendChild(like);
            votes.appendChild(dislike);
            newComment.appendChild(votes);

            commentSection.prepend(newComment);
            document.getElementById("commentContent").value = "";
        } else {
            console.error("Failed to add comment");
            Swal.fire({
                title: "Fail!",
                text: "Failed to add comment",
                icon: "error",
            });
        }
    });

function makeEditForm(commentText, newComment) {
    const form = document.createElement("form");
    form.className = "editForm";

    const buttonsForm = document.createElement("div");
    buttonsForm.className = "buttonsForm";

    const textarea = document.createElement("textarea");
    textarea.classList.add("commentContent");
    textarea.setAttribute("name", "content");
    textarea.setAttribute("rows", "3");
    textarea.setAttribute("maxlength", "500");
    textarea.setAttribute("required", "true");
    textarea.textContent = commentText;
    form.appendChild(textarea);

    const postButton = document.createElement("button");
    postButton.setAttribute("type", "submit");
    postButton.classList.add("button", "editButton");
    postButton.textContent = "Post";
    buttonsForm.appendChild(postButton);

    const cancelButton = document.createElement("button");
    cancelButton.setAttribute("type", "button");
    cancelButton.classList.add("button", "cancelButton");
    cancelButton.textContent = "Cancel";
    cancelButton.addEventListener("click", (event) => {
        event.preventDefault;
        editCancel(newComment);
    });
    buttonsForm.appendChild(cancelButton);

    form.appendChild(buttonsForm);
    form.addEventListener("submit", saveEdit);
    form.setAttribute("hidden", "true");

    return form;
}

function createLikeDislike(className, symbol, type) {
    const button = document.createElement("button");
    button.className = className;

    const icon = document.createElement("span");
    icon.className = "material-symbols-outlined";
    icon.textContent = symbol;

    const number = document.createElement("span");
    number.textContent = 0;
    number.className = type;

    button.appendChild(icon);
    button.appendChild(number);

    return button;
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

function deleteComment() {
    const comments = document.querySelectorAll(".comment");
    comments.forEach(function (comment) {
        const delComment = comment.querySelector(".delete");
        if (delComment) {
            delComment.addEventListener("click", (event) => {
                event.preventDefault();
                deleteCommentItem(comment);
            });
        }
    });
}
deleteComment();

async function deleteCommentItem(comment) {
    const commentId = comment.getAttribute("comment-id");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const data = await fetch("/api/comment/" + commentId, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                }).then((response) => response.json());

                const section = document.getElementById("comments");

                if (data.success) {
                    if (section.querySelectorAll(".comment").length === 1) {
                        const noCommentsDiv = document.createElement("div");
                        const noComments = document.createElement("p");
                        noCommentsDiv.id = "no_comments";
                        noComments.textContent = "There are no comments yet";
                        noCommentsDiv.appendChild(noComments);
                        section.appendChild(noCommentsDiv);
                    }
                    Swal.fire({
                        title: "Deleted!",
                        text: data.success,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                    comment.remove();
                } else {
                    Swal.fire({
                        title: "Fail!",
                        text: data.error,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`
                Request failed: ${error}
              `);
            }
        }
    });
}

function makeDropDown(comment) {
    const options = [
        {
            icon: "delete",
            label: "Delete",
            class: "delete",
            fn: deleteCommentItem,
        },
        { icon: "edit", label: "Edit", class: "edit", fn: editCommentItem },
    ];

    const dropdown = document.createElement("div");
    dropdown.className = "dropdown";

    const moreButton = document.createElement("button");
    moreButton.className = "more";
    moreButton.addEventListener("click", function (event) {
        toggleMenu(moreButton, event);
    });

    const moreIcon = document.createElement("span");
    moreIcon.className = "material-symbols-outlined";
    moreIcon.textContent = "more_vert";

    moreButton.appendChild(moreIcon);

    const dropdownContent = document.createElement("div");
    dropdownContent.classList.add("dropdown-content", "hidden");

    options.forEach((option) => {
        const optionDiv = document.createElement("div");
        optionDiv.className = "dropdown-option";

        const icon = document.createElement("span");
        icon.className = "material-symbols-outlined";
        icon.textContent = option.icon;

        const label = document.createElement("span");
        label.textContent = option.label;

        optionDiv.appendChild(icon);
        optionDiv.appendChild(label);

        if (option.class) {
            optionDiv.classList.add(option.class);
        }

        optionDiv.addEventListener("click", (e) => {
            e.stopPropagation();
            option.fn(comment);
        });

        dropdownContent.appendChild(optionDiv);
    });

    dropdown.appendChild(moreButton);
    dropdown.appendChild(dropdownContent);

    return dropdown;
}

function editCommentItem(comment) {
    const form = comment.querySelector(".editForm");
    const commentText = comment.querySelector(".comment_text");
    comment.querySelector("textarea").value = commentText.textContent;
    form.removeAttribute("hidden");
    commentText.setAttribute("hidden", "true");
}

function editComment() {
    const comments = document.querySelectorAll(".comment");
    comments.forEach(function (comment) {
        const editButton = comment.querySelector(".edit");
        const form = comment.querySelector(".editForm");
        if (form) {
            form.addEventListener("submit", saveEdit);
        }
        if (editButton) {
            editButton.addEventListener("click", function (event) {
                event.preventDefault();
                editCommentItem(comment);
            });
        }
    });
}
editComment();

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
                let editDate = comment.querySelector("#edit_date");

                if (data.success) {
                    if (editDate === null) {
                        const date = comment.querySelector(".date");
                        editDate = document.createElement("p");
                        editDate.className = "date";
                        editDate.id = "edit_date";
                        date.insertAdjacentElement("afterend", editDate);
                    }
                    editDate.textContent = "Edited " + data.edit_date;
                    content.textContent = commentContent;
                    Swal.fire({
                        title: "Saved!",
                        text: data.success,
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                } else {
                    Swal.fire({
                        title: "Fail!",
                        text: data.error,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
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

// Teste
function reportComment() {
    const comments = document.querySelectorAll(".comment");
    comments.forEach(function (comment) {
        const reportComment = comment.querySelector(".report");
        if (reportComment) {
            reportComment.addEventListener("click", (event) => {
                event.preventDefault();
                openReportCommentForm(comment);
            });
        }
    });
}
reportComment();

const reportPopup = document.getElementById("report_content_popup");
const idContent = reportPopup.querySelector("#id_content");
const textareaForm = reportPopup.querySelector("#reason");

function openReportNewsForm(valeu) {
    idContent.valeu = valeu;
    reportPopup.style.display = "block";
}

function openReportCommentForm(comment) {
    const commentId = comment.getAttribute("comment-id");
    idContent.valeu = commentId;
    reportPopup.style.display = "block";
}

function closeReportContentForm() {
    idContent.value = "";
    textareaForm.value = "";
    reportPopup.style.display = "none";
}

reportPopup
    .querySelector("#report_form")
    .addEventListener("submit", async function (event) {
        event.preventDefault();
        const reason = this.querySelector("#reason").value;

        const data = {
            id_content: idContent.valeu,
            reason: reason,
        };
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to report this content?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, report it!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const message = await fetch("/api/content/report/", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify(data),
                    }).then((response) => response.json());

                    if (message.success) {
                        Swal.fire({
                            title: "Report make!",
                            text: message.success,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        });
                    } else {
                        Swal.fire({
                            title: "Fail!",
                            text: message.error,
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                        });
                    }
                    closeReportContentForm();
                } catch (error) {
                    console.error("Error:", error);
                    Swal.showValidationMessage(`
                Request failed: ${error}
              `);
                }
            }
        });
    });
