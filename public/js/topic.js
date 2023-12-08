"use strict";

document.querySelector("#follow_topic").addEventListener("click", (event) => {
    const topic = document.querySelector("#id_topic").value;
    sendAjaxRequest(
        "POST",
        `/api/topic/${event.target.dataset.operation}`,
        { topic },
        followTopicHandler
    );
});

function followTopicHandler() {
    if (this.status != 200) window.location = "/";
    const action = JSON.parse(this.responseText).follow;
    const count = document.querySelector("#folowers_topic_count");
    const oldValue = parseInt(count.textContent.trim());
    const button = document.querySelector("#follow_topic");
    button.dataset.operation = action;
    button.textContent = action;
    if (action == "follow") count.textContent = oldValue - 1;
    else count.textContent = oldValue + 1;
}
