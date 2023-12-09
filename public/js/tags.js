"use strict";

const tagsList = document.querySelector("#tagsList");
const inputField = document.getElementById("tagInput");

function createTag() {
    const tag = document.createElement("li");
    tag.className = "tag";
    const text = inputField.value.trim().toLowerCase();

    if (text !== "" && !document.getElementById(text)) {
        const tagText = document.createElement("span");
        tagText.textContent = text;
        tagText.className = "tagText";
        tag.id = text;

        const removeButton = document.createElement("span");
        removeButton.className = "remove";
        removeButton.textContent = "X";
        removeButton.addEventListener(
            "click",
            () => {
                removeTag(tag);
            },
            { once: true }
        );
        tag.appendChild(tagText);
        tag.appendChild(removeButton);
        tagsList.appendChild(tag);
    }
    inputField.value = "";
}

function removeTag(tagToRemove) {
    if (tagToRemove) {
        tagToRemove.remove();
    }
}

const form = document.getElementById("newsForm");

form?.addEventListener("submit", (event) => {
    event.preventDefault();
    const tagsInput = document.createElement("input");
    tagsInput.type = "hidden";
    tagsInput.name = "tags";

    let liElements = tagsList.getElementsByClassName("tagText");
    let tagArray = [];
    for (let i = 0; i < liElements.length; i++) {
        tagArray.push(liElements[i].textContent);
    }

    tagsInput.value = JSON.stringify(tagArray);

    form.appendChild(tagsInput);

    form.submit();

  });

document.querySelector('#follow_tag')?.addEventListener('click', event => {
  const tag =  document.querySelector('#id_tag').value;
  sendAjaxRequest(
        'POST',
        `/api/tag/${event.target.dataset.operation}`,
        {tag},
        followTagHandler
  );
})

function followTagHandler() {
 // if (this.status != 200) window.location = '/';
  const action = JSON.parse(this.responseText).follow;
  const count = document.querySelector("#folowers_tag_count");
  const oldValue = parseInt(count.textContent.trim());
  const button = document.querySelector("#follow_tag");
  button.dataset.operation = action;
  button.textContent = action;
  if(action=="follow") count.textContent = oldValue - 1;
  else count.textContent = oldValue + 1
}

