"use strict";

// new comment
document
    .getElementById("commentForm")
    .addEventListener("submit", async function (event) {
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

            const form = document.createElement("form");
            form.className = "editForm";

            const textarea = document.createElement("textarea");
            textarea.classList.add("commentContent");
            textarea.setAttribute("name", "content");
            textarea.setAttribute("rows", "3");
            textarea.setAttribute("maxlength", "500");
            textarea.setAttribute("required", "true");
            textarea.textContent = data.content;
            form.appendChild(textarea);

            const postButton = document.createElement("button");
            postButton.setAttribute("type", "submit");
            postButton.classList.add("button", "editButton");
            postButton.textContent = "Post";
            form.appendChild(postButton);

            const cancelButton = document.createElement("button");
            cancelButton.setAttribute("type", "button");
            cancelButton.classList.add("button", "cancelButton");
            cancelButton.textContent = "Cancel";
            cancelButton.addEventListener("click", (event) => {
                event.preventDefault;
                editCancel(newComment);
            });
            form.appendChild(cancelButton);

            form.addEventListener("submit", saveEdit);
            form.setAttribute("hidden", "true");

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
        }
    });

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
    document
        .querySelectorAll("#comments .dropdown-content")
        .forEach((dropdown) => {
            dropdown.style.display = "none";
        });
    const dropdown = button.nextElementSibling;
    if (dropdown) {
        event.stopPropagation();
        toggleDisplay(dropdown);
    }
}

function deleteComment() {
    const comments = document.querySelectorAll(".comment");
    comments.forEach(function (comment) {
        const delComment = comment.querySelector(".delete");
        delComment.addEventListener("click", (event) => {
            event.preventDefault();
            deleteCommentItem(comment);
        });
    });
}
deleteComment();

async function deleteCommentItem(comment) {
    const commentId = comment.getAttribute("comment-id");
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
        const message = document.createElement("p");

        if (data.success) {
            if (section.querySelectorAll(".comment").length === 1) {
                const noCommentsDiv = document.createElement("div");
                const noComments = document.createElement("p");
                noCommentsDiv.id = "no_comments";
                noComments.textContent = "There are no comments yet";
                noCommentsDiv.appendChild(noComments);
                section.appendChild(noCommentsDiv);
            }
            message.className = "success";
            message.textContent = data.success;
            comment.remove();
        } else {
            message.className = "error";
            message.textContent = data.error;
        }
        section.prepend(message);
    } catch (error) {
        console.error("Error:", error);
    }
}

function makeDropDown(comment) {
    const options = [
        { icon: "flag", label: "Report", fn: () => {} },
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
        toggleMenu(this, event);
    });

    const moreIcon = document.createElement("span");
    moreIcon.className = "material-symbols-outlined";
    moreIcon.textContent = "more_vert";

    moreButton.appendChild(moreIcon);

    const dropdownContent = document.createElement("div");
    dropdownContent.className = "dropdown-content";

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
        form.addEventListener("submit", saveEdit);
        editButton.addEventListener("click", function (event) {
            event.preventDefault();
            editCommentItem(comment);
        });
    });
}
editComment();

async function saveEdit(event) {
    event.preventDefault();
    const comment = event.target.parentElement;
    const commentId = comment.getAttribute("comment-id");
    const commentContent = comment.querySelector(".commentContent").value;
    try {
        const data = await fetch("/api/comment/" + commentId + "/edit", {
            method: "PATCH",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ content: commentContent }),
        }).then((response) => response.json());

        const content = comment.querySelector(".comment_text");
        const message = document.createElement("p");

        if (data.success) {
            content.textContent = commentContent;
            message.className = "success";
            message.textContent = data.success;
        } else {
            message.className = "error";
            message.textContent = data.error;
        }
        editCancel(comment);

        document.body.appendChild(message);
    } catch (error) {
        console.error("Error:", error);
    }
}

function editCancel(comment) {
    const content = comment.querySelector(".comment_text");
    content.removeAttribute("hidden");

    const form = comment.querySelector(".editForm");
    form.setAttribute("hidden", "true");
}
