"use strict";

const pusher = new Pusher("c0fb97ab5d870529ef09", {
    cluster: "eu",
    encrypted: true,
});

const user_id_not_parsed = document.querySelector("#button_profile")?.href;
const user_id = user_id_not_parsed[user_id_not_parsed.length - 1];

// notificações follow user
const follow_user_channel = pusher.subscribe("follow-user" + user_id);
follow_user_channel.bind("notification", (data) => {
    const div = notificationTemplate(data.notification_id);
    const a = document.createElement("a");
    a.href = location.origin + "/profile/" + encodeURIComponent(data.sender_id);
    a.textContent = data.sender_name;
    div.appendChild(a);
    div.append(" is following you!");
});

// notificacoes news item vote
const news_item_vote_channel = pusher.subscribe("news-item-vote" + user_id);
news_item_vote_channel.bind("news-item-vote", (data) => {
    const div = notificationTemplate(data.notification_id);
    const profileLink = document.createElement("a");
    profileLink.href =
        location.origin + "/profile/" + encodeURIComponent(data.sender_id);
    profileLink.textContent = data.sender_name;
    const postLink = document.createElement("a");
    postLink.href =
        location.origin + "/news/" + encodeURIComponent(data.post_id);
    postLink.textContent = data.post_name;
    div.append(profileLink, " voted on your news item. ", postLink);
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

function notificationTemplate(id) {
    // remove mensagem a dizer que nao existem notificações
    document.querySelector("#notifications_pop_up > div")?.remove();

    // muda icon para notificações nao lidas
    const icon = document.querySelector("#notification_icon > span");
    if (icon) icon.innerHTML = "notifications_unread";

    const article = document.createElement("article");
    article.classList.add("user_news", "new_notification");
    article.setAttribute("id", id);
    const h4 = document.createElement("h4");
    const button = document.createElement("button");
    button.classList.add("notification_button");
    const div = document.createElement("div");
    const span = document.createElement("span");
    span.classList.add("material-symbols-outlined", "icon_red");
    span.innerHTML = "delete";

    button.appendChild(span);
    h4.appendChild(button);
    h4.appendChild(div);
    article.appendChild(h4);

    if (
        document.querySelector("#notifications_pop_up")?.children.length === 6
    ) {
        document
            .querySelector("#notifications_pop_up")
            .removeChild(
                document.querySelector("#notifications_pop_up").lastChild
            );
    }

    return div;
}

function deleteNotificationHandler() {
    if (this.status != 200) window.location = "/";
    const selector = 'article[id="' + JSON.parse(this.responseText).id + '"]';
    const element = document.querySelector(selector);
    element.remove();
    const mainElement = document.querySelector("#notifications_pop_up");
    if (mainElement.children.length == 1) {
        const pElement = document.createElement("p");
        pElement.textContent = "There are no notifications to show.";
        mainElement.prepend(pElement);
    }
}
