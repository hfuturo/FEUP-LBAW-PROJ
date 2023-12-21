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

// notificacao new comment
const new_comment_channel = pusher.subscribe("new-comment" + user_id);
new_comment_channel.bind("new-comment", (data) => {
    const div = notificationTemplate(data.notification_id);
    const link = document.createElement("a");
    link.href = location.origin + "/news/" + data.post_id;
    link.textContent = data.post_title;
    div.append(link, " has a new comment, go check!");
});

// notificacao comment vote
const commentVoteChannel = pusher.subscribe("comment-vote" + user_id);
commentVoteChannel.bind("comment-vote", (data) => {
    console.log(data);
    const div = notificationTemplate(data.notification_id);
    const profileLink = document.createElement("a");
    profileLink.href =
        location.origin + "/profile/" + encodeURIComponent(data.sender_id);
    profileLink.textContent = data.sender_name;
    const postLink = document.createElement("a");
    postLink.href =
        location.origin + "/news/" + encodeURIComponent(data.post_id);
    postLink.textContent = data.post_name;
    div.append(profileLink, " voted on your comment in ", postLink);
});

document.querySelectorAll(".notification_button").forEach((button) => {
    addDeleteNotificationEventListener(button);
});

function addDeleteNotificationEventListener(button) {
    button.addEventListener("click", () => {
        let notification = button.parentNode.parentNode.id;
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
    document.querySelector("#notifications_pop_up > p")?.remove();

    // muda icon para notificações nao lidas
    const icon = document.querySelector("#notification_icon > span");
    if (icon) icon.innerHTML = "notifications_unread";

    const article = document.createElement("article");
    article.classList.add("user_news", "new_notification");
    article.setAttribute("id", id);
    const divWrapper = document.createElement("div");
    const button = document.createElement("button");
    button.classList.add("notification_button");
    const div = document.createElement("div");
    const span = document.createElement("span");
    span.classList.add("material-symbols-outlined", "icon_red");
    span.innerHTML = "delete";

    button.appendChild(span);
    divWrapper.appendChild(button);
    divWrapper.appendChild(div);
    article.appendChild(divWrapper);

    document.querySelector("#notifications_pop_up").prepend(article);

    addDeleteNotificationEventListener(button);

    if (
        document.querySelector("#notifications_pop_up")?.children.length === 6
    ) {
        document.querySelector("#notifications_pop_up").lastChild.remove();
    }

    return div;
}

function deleteNotificationHandler() {
    if (this.status != 200) window.location = "/";
    const selector = 'article[id="' + JSON.parse(this.responseText).id + '"]';
    const element = document.querySelector(selector);
    element.remove();
    const mainElement = document.querySelector("#notifications_pop_up");
    const notificationPage = document.querySelector("#list_notifications");
    if (
        mainElement.children.length === 1 ||
        notificationPage?.children.length === 2
    ) {
        const pElement = document.createElement("p");
        pElement.textContent = "There are no notifications to show.";
        mainElement.prepend(pElement);
    }
}

// fecha popup das notificacoes caso clique fora do popup e remove class 'new_notification'
// para depois caso clique novamente nao ter o background de uma notificacao nova
window.addEventListener("click", (event) => {
    const notification_popup = document.getElementById("notifications_pop_up");
    const icon_button = document.querySelector("#notification_icon");
    if (
        notification_popup.style.display === "block" &&
        (!notification_popup.contains(event.target) ||
            icon_button.contains(event.target))
    ) {
        notification_popup.style.translate = "";
        notification_popup.addEventListener(
            "transitionend",
            () => {
                notification_popup.style.display = "none";
            },
            { once: true }
        );
        removeNotificationBackgroundColor();
    }
});

document
    .querySelector("#notification_icon")
    ?.addEventListener("click", async (event) => {
        event.stopPropagation();
        let lista = document.getElementById("notifications_pop_up");

        if (lista.style.display === "block") {
            lista.style.translate = "";
            lista.addEventListener(
                "transitionend",
                () => {
                    lista.style.display = "none";
                },
                { once: true }
            );
        } else {
            setTimeout(() => {
                lista.style.translate = "0 0";
            }, 0);
            lista.style.display = "block";
        }
        if (lista.style.display === "none") {
            removeNotificationBackgroundColor();
        }

        // muda icon para notificacoes vistas (normal)
        const icon = document.querySelector("#notification_icon > span");
        if (icon) icon.innerHTML = "notifications";

        // atualiza bd e coloca notificacoes a viewed
        await fetch("/api/notification/view", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });
    });

function removeNotificationBackgroundColor() {
    document
        .querySelectorAll(
            "#notifications_pop_up > article.user_news.new_notification"
        )
        ?.forEach((notification) => {
            notification.classList.remove("new_notification");
        });
}
