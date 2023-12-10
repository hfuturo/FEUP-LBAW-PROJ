"use strict";

document
    .getElementById("manage_report_button")
    .addEventListener("click", function () {
        let subOptions = document.getElementById("report_sub_options");
        subOptions.style.display =
            subOptions.style.display === "block" ? "none" : "block";
        let buttonSpan = document.getElementById("manage_report_button").querySelector("span");
        console.log(buttonSpan)
        buttonSpan.textContent =
        buttonSpan.textContent === "expand_more" ? "expand_less" : "expand_more";
    });

function openTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "block";
}

function closeTopicProposal() {
    document.getElementById("topic_proposal_popup").style.display = "none";
}

document.querySelectorAll(".topics_proposal").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idTopic = button.id;
        sendAjaxRequest(
            "post",
            `/manage_topic/${event.target.dataset.operation}`,
            { idTopic },
            topicProposalHandler
        );
    });
});

function topicProposalHandler() {
    if (this.status != 200) window.location = "/";
    let idTopic = JSON.parse(this.responseText);
    let element = document.getElementById(idTopic);
    element.remove();
}

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

            const more = makeDropDown();

            commentHead.appendChild(commentAuthorPfp);
            commentHead.appendChild(commentAuth);
            commentHead.appendChild(commentDate);
            commentHead.appendChild(more);

            newComment.appendChild(commentHead);
            newComment.appendChild(commentText);

            const votes = document.createElement("div");
            votes.className = "votes";

            const like = createLikeDislick("accept", "thumb_up");
            const nLikes = document.createElement("p");
            nLikes.textContent = 0;

            const dislike = createLikeDislick("remove", "thumb_down");
            const nDislikes = document.createElement("p");
            nDislikes.textContent = 0;

            votes.appendChild(like);
            votes.appendChild(nLikes);
            votes.appendChild(dislike);
            votes.appendChild(nDislikes);
            newComment.appendChild(votes);

            commentSection.prepend(newComment);
            deleteComment();
            document.getElementById("commentContent").value = "";
        } else {
            console.error("Failed to add comment");
        }
    });

function toggleDisplay(element) {
    if (element.style.display === "block") {
        element.style.display = "none";
    } else {
        element.style.display = "block";
    }
}

function toggleMenu(button) {
    const dropdown = button.nextElementSibling;
    if (dropdown) {
        toggleDisplay(dropdown);
    }
}

function deleteComment() {
    const comments = document.querySelectorAll(".comment");

    comments.forEach(function (comment) {
        const delComment = comment.querySelector(".delete");
        delComment.addEventListener("click", async function (event) {
            event.preventDefault();

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
        });
    });
}

deleteComment();

function makeDropDown() {
    const options = [
        { icon: "flag", label: "Report" },
        { icon: "delete", label: "Delete", class: "delete" },
        { icon: "edit", label: "Edit" },
    ];

    const dropdown = document.createElement("div");
    dropdown.className = "dropdown";

    const moreButton = document.createElement("button");
    moreButton.className = "more";
    moreButton.addEventListener("click", function () {
        toggleMenu(this);
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

        dropdownContent.appendChild(optionDiv);
    });

    dropdown.appendChild(moreButton);
    dropdown.appendChild(dropdownContent);

    return dropdown;
}

function createLikeDislick(className, symbol) {
    const button = document.createElement("button");
    button.className = className;

    const icon = document.createElement("span");
    icon.className = "material-symbols-outlined";
    icon.textContent = symbol;

    button.appendChild(icon);

    return button;
}
