"use strict";

const tagContainer = document.querySelector(".tag-container");
const tagInput = document.querySelector("#tagInput");
const form = document.querySelector("#newsForm");
form?.reset();
if (tagContainer) {
    tagContainer.style.font = getComputedStyle(tagInput).font;
    createTags();
}

function createTags() {
    if (tagInput.value.trim().length === 0) return;
    const insertedTags = [...tagContainer.querySelectorAll(".tag-item")].map(
        (tagElement) => tagElement.textContent.slice(1)
    );
    const tags = tagInput.value
        .trim()
        .replace(/^#/, "")
        .split(/\s[\s#]*/)
        .filter((tag) => tag.length > 0 && !tag.startsWith("#"))
        .filter((tag) => !insertedTags.includes(tag));

    tagInput.value = "";
    if (tags.length === 0) return;

    for (const tag of tags) {
        const tagElement = document.createElement("span");
        tagElement.className = "tag-item";
        tagElement.textContent = "#" + tag;
        tagElement.tabIndex = 0;
        tagElement.addEventListener("click", () => {
            while (tagElement.nextSibling?.nodeName === "#text") {
                tagElement.nextSibling.remove();
            }
            tagElement.remove();
            while (tagContainer.firstChild?.nodeName === "#text") {
                tagContainer.firstChild.remove();
            }
        });
        tagElement.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault();
                tagElement.click();
            }
        });
        tagContainer.insertBefore(tagElement, tagInput);
        tagContainer.insertBefore(document.createTextNode(" "), tagInput);
    }
}

tagInput?.addEventListener("input", (e) => {
    if (tagInput.value.endsWith(" ")) {
        createTags();
    }
});

tagInput?.addEventListener("keypress", (e) => {
    if (e.key === "Enter" && !e.ctrlKey) {
        e.preventDefault();
        createTags();
    }
});

tagContainer?.addEventListener("click", (e) => {
    tagInput.focus();
});

function removeTag(tagToRemove) {
    if (tagToRemove) {
        tagToRemove.remove();
    }
}

form?.addEventListener("submit", (event) => {
    event.preventDefault();
    createTags();
    tagInput.value = tagContainer.textContent.trim();
    while (tagContainer.firstChild !== tagInput) {
        tagContainer.firstChild.remove();
    }
    form.submit();
});

document.querySelector("#follow_tag")?.addEventListener("click", (event) => {
    const tag = document.querySelector("#id_tag").value;
    sendAjaxRequest(
        "POST",
        `/api/tag/${event.target.dataset.operation}`,
        { tag },
        followTagHandler
    );
});

function followTagHandler() {
    // if (this.status != 200) window.location = '/';
    const action = JSON.parse(this.responseText).follow;
    const count = document.querySelector("#folowers_tag_count");
    const oldValue = parseInt(count.textContent.trim());
    const button = document.querySelector("#follow_tag");
    button.dataset.operation = action;
    button.textContent = action;
    if (action == "follow") count.textContent = oldValue - 1;
    else count.textContent = oldValue + 1;
}
