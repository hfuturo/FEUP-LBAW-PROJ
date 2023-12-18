const pusher = new Pusher("c0fb97ab5d870529ef09", {
    cluster: "eu",
    encrypted: true,
});

const user_id_not_parsed = document.querySelector("#button_profile")?.href;
const user_id = user_id_not_parsed[user_id_not_parsed.length - 1];

const channel = pusher.subscribe("follow-user" + user_id);
channel.bind("notification", function (data) {
    console.log(data);
});

document.querySelectorAll(".notification_button").forEach((button) => {
    button.addEventListener("click", (event) => {
        let notification = event.target.parentNode.parentNode.parentNode.id;
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
    let mainElement = document.querySelector("#list_notifications");
    if (mainElement.children.length <= 2) {
        let pElement = document.createElement("p");
        pElement.textContent = "There are no notifications to show.";
        mainElement.appendChild(pElement);
    }
}
