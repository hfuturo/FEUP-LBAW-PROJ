document.querySelectorAll(".notification_button").forEach((button) => {
    button.addEventListener("click", (event) => {
        let notification = event.target.parentNode.parentNode.id;
        sendAjaxRequest(
            "DELETE",
            "/api/notification/destroy",
            { notification },
            deleteNotificationHandler
        );
    });
});

function deleteNotificationHandler() {
    if (this.status != 200) window.location = "/";
    let selector = 'article[id="' + JSON.parse(this.responseText).id + '"]';
    let element = document.querySelector(selector);
    element.remove();
}