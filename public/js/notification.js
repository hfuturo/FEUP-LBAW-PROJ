const pusher = new Pusher(pusherAppKey, {
    cluster: pusherCluster,
    encrypted: true
});

const channel = pusher.subscribe('NewsCore');
channel.bind('notification', function(data) {
    console.log(`New notification: ${data.message}`);
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