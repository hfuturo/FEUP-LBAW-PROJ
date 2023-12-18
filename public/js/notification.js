const pusher = new Pusher("c0fb97ab5d870529ef09", {
    cluster: "eu",
    encrypted: true,
});

const user_id_not_parsed = document.querySelector("#button_profile")?.href;
const user_id = user_id_not_parsed[user_id_not_parsed.length - 1];

const channel = pusher.subscribe("follow-user" + user_id);
channel.bind("notification", (data) => {
    // remove mensagem a dizer que nao existem notificações
    document.querySelector("#notifications_pop_up > p")?.remove();

    // muda icon para notificações nao lidas
    const icon = document.querySelector("#notification_icon > span");
    if (icon) icon.innerHTML = "notifications_unread";

    const article = document.createElement("article");
    article.classList.add("user_news");
    article.setAttribute("id", data.notification_id);
    const h4 = document.createElement("h4");
    const button = document.createElement("button");
    button.classList.add("notification_button");
    const span = document.createElement("span");
    span.classList.add("material-symbols-outlined", "icon_red");
    span.innerHTML = "delete";
    const a = document.createElement("a");
    a.href = location.origin + "/profile/" + encodeURIComponent(data.sender_id);
    a.innerHTML = data.sender_name;
    button.appendChild(span);
    h4.appendChild(button);
    h4.appendChild(a);
    h4.append(" is following you!");
    article.appendChild(h4);

    addDeleteNotificationEventListener(button);
    document.getElementById("notifications_pop_up").prepend(article);
});

document.querySelectorAll(".notification_button").forEach((button) => {
    addDeleteNotificationEventListener(button);
});

function addDeleteNotificationEventListener(button) {
    button.addEventListener("click", (event) => {
        let notification = event.target.parentNode.parentNode.parentNode.id;
        sendAjaxRequest(
            "DELETE",
            "/api/notification/destroy",
            { notification },
            deleteNotificationHandler
        );
    });
}

function deleteNotificationHandler() {
    if (this.status != 200) window.location = "/";
    let selector = 'article[id="' + JSON.parse(this.responseText).id + '"]';
    let element = document.querySelector(selector);
    element.remove();
    let mainElement = document.querySelector("#notifications_pop_up");
    if (mainElement.children.length <= 2) {
        let pElement = document.createElement("p");
        pElement.textContent = "There are no notifications to show.";
        mainElement.prepend(pElement);
    }
}
