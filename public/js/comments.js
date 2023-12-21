"use strict";

// new comment
document
    .getElementById("commentForm")
    ?.addEventListener("submit", async function (event) {
        event.preventDefault();
        event.stopPropagation();
        const newsId = this.getAttribute("data-news-id");
        const link = `/news/${newsId}?page=1`;
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
            document.getElementById("comments").scrollIntoView({ behavior: "smooth" });
    
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
        /*
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

            const commentAuthorPfp = document.createElement("img");
            commentAuthorPfp.className = "author_comment_pfp";
            commentAuthorPfp.src = "/api/fetch_pfp/" + data.author.id;

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
            votes.id = data.id;

            const like = createLikeDislike("accept", "thumb_up", "up_count");
            const dislike = createLikeDislike(
                "remove",
                "thumb_down",
                "down_count"
            );

            votes.appendChild(like);
            votes.appendChild(dislike);
            newComment.appendChild(votes);

            commentSection.insertBefore(
                newComment,
                commentSection.querySelector(".search_form").nextElementSibling
            );
            document.getElementById("commentContent").value = "";

            like.addEventListener("click", () => {
                let content =
                    like.parentNode.parentNode.getAttribute("comment-id");
                let method = "POST";
                let action, value;
                if (like.style.backgroundColor == "green") {
                    action = "destroy";
                    method = "DELETE";
                } else if (
                    like.parentNode.querySelector(".remove").style
                        .backgroundColor == "red"
                ) {
                    action = "update";
                    method = "POST";
                } else {
                    action = "create";
                    method = "POST";
                }
                value = 1;
                sendAjaxRequest(
                    `${method}`,
                    `/api/vote/${action}`,
                    { content, value },
                    voteHandler
                );
            });

            dislike.addEventListener("click", () => {
                let name = dislike.className;
                let content =
                    dislike.parentNode.parentNode.getAttribute("comment-id");
                let method = "POST";
                let action, value;
                if (dislike.style.backgroundColor == "red") {
                    action = "destroy";
                    method = "DELETE";
                } else if (
                    dislike.parentNode.querySelector(".accept").style
                        .backgroundColor == "green"
                ) {
                    action = "update";
                    method = "POST";
                } else {
                    action = "create";
                    method = "POST";
                }
                value = -1;

                sendAjaxRequest(
                    `${method}`,
                    `/api/vote/${action}`,
                    { content, value },
                    voteHandler
                );
            });
        } else {
            console.error("Failed to add comment");
            Swal.fire({
                title: "Fail!",
                text: "Failed to add comment",
                icon: "error",
            });
>>>>>>> public/js/comments.js
        }
        */
    };

    function AlertMessage(title, text, icon){
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
        });
    }

    /*
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
    button.classList.add("vote", className);

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
*/

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
                const data = await fetch(`/api/comment/${commentId}/remove`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                }).then((response) => response.json());

                
                if (data.success) {
                    const urlParams = new URLSearchParams(currentURL.substring(currentURL.indexOf("?") + 1));
                    const pageNumber = urlParams.get("page");
                    const section = comment.parentNode;

                    if(pageNumber > 1 || pageNumber !== null){
                        const commentPage = section.querySelectorAll("article");
                        const numberComments = commentPage.length;
                        /*const paginator = document.querySelectorAll(".paginate a");*/
                        if(numberComments === 1){
                            urlParams.set("page", (pageNumber - 1));  
                            currentURL = currentURL.split("?")[0] + "?" + urlParams.toString();
                            history.pushState(null, '', currentURL);
                            /*paginator.removeChild(paginator.lastElementChild);*/
                        }
                        
                    }
                    const [response, raw_data] = await sendFetchRequest(
                        "GET",
                        currentURL,
                        null,
                        "text"
                    );
                    updateComments(raw_data);
                    document.getElementById("comments").scrollIntoView({ behavior: "smooth" });

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
    /*
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
            Swal.showValidationMessage(`Request failed: ${error}`);
        }
    }
    */
}


/*
function editCommentItem(button) {
    const comment = button.closest("article");
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
            toggleMenu(moreButton, e);
        });

        dropdownContent.appendChild(optionDiv);
    });

    dropdown.appendChild(moreButton);
    dropdown.appendChild(dropdownContent);

    return dropdown;
}
*/


function editCommentItem(button) {
    const comment = button.closest("article");
    const form = comment.querySelector(".editForm");
    console.log(form);
    const commentText = comment.querySelector(".comment_text");
    console.log(commentText);
    const textarea = comment.querySelector("textarea");
    console.log(textarea);
    textarea.value = commentText.textContent;
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


const reportPopup = document.getElementById("report_content_popup");
const idContent = reportPopup.querySelector("#id_content");
const textareaForm = reportPopup.querySelector("#reason");

function openReportNewsForm(value) {
    idContent.value = value;
    reportPopup.style.display = "block";
}

function openReportCommentForm(button) {
    const comment = button.closest("article");
    const commentId = comment.getAttribute("comment-id");
    idContent.value = commentId;
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
            id_content: idContent.value,
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
        window.history.pushState(raw_data, "", response.url);
        updateComments(raw_data);
        document.getElementById("comments").scrollIntoView({ behavior: "smooth" });
    }
    
    function updateComments(raw_data) {
        commentSection.innerHTML = raw_data;
        commentSection.querySelectorAll(".paginate a").forEach((link) => {
            link.addEventListener("click", feedLinksHandler);
        });
    }
    
    window.addEventListener("popstate", (event) => {
        if (event.state) updateComments(event.state);
    });