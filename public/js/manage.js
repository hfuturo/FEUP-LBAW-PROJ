"use strict";

const filterUsersInput = document.querySelector("#users input");

if (filterUsersInput) {
    filterUsersInput.addEventListener("input", async function () {
        sendAjaxRequest(
            "post",
            "/api/manage",
            { search: filterUsersInput.value },
            filterUsersHandler
        );
    });
}

document
    .querySelector("#topics input")
    ?.addEventListener("input", async (e) => {
        const [response, data] = await sendFetchRequest(
            "POST",
            "/api/topics/filter",
            { search: e.target.value },
            "json"
        );

        const topicsList = document.querySelector("#all_topics");
        topicsList.innerHTML = "";

        for (const topic of data.topics) {
            const li = document.createElement("li");
            li.id = "topic" + topic.id;
            console.log(topic);
            li.classList.add("topic");
            const link = document.createElement("a");
            link.href = "/topic/" + topic.id;
            link.textContent = topic.name;
            const div = document.createElement("div");
            div.classList.add("manage_div");
            const numberNews = document.createElement("p");
            const numberFollowers = document.createElement("p");
            numberNews.textContent = "Number of news: " + topic.count;
            div.append(numberNews, numberFollowers);
            li.append(link, div);
            topicsList.append(li);
        }

        for (const follower of data.followers) {
            const numberFollowers = document.querySelector(
                `#topic${follower.id} .manage_div :nth-child(2)`
            );
            numberFollowers.textContent = "Followers: " + follower.count;
        }
    });

function filterUsersHandler() {
    if (this.status != 200) window.location = "/";
    const data = JSON.parse(this.responseText);

    const users = data.users;
    const topics = data.topics;

    const usersList = document.querySelector("#all_users");

    // limpa a lista
    usersList.innerHTML = "";

    // reconstroi lista
    for (const user of users) {
        const li = document.createElement("li");
        li.classList.add("user");
        li.setAttribute("id", user.id);
        const nameWrapper = document.createElement("div");
        nameWrapper.classList.add("name_wrapper");
        const buttonsDiv = document.createElement("div");
        const link = document.createElement("a");
        link.href = "/profile/" + user.id;
        link.innerHTML = user.name;
        nameWrapper.append(link);
        const buttonSpan = document.createElement("span");
        const blockUnblockButton = document.createElement("button");
        if (parseInt(user_id) !== user.id && user.type !== "admin") {
            blockUnblockButton.classList.add(
                user.blocked ? "unblock" : "block"
            );
            buttonSpan.innerHTML = user.blocked ? "Unblock" : "Block";
            blockUnblockButton.appendChild(buttonSpan);
        }

        const linksDiv = document.createElement("div");
        linksDiv.appendChild(nameWrapper);
        if (user.id_topic !== null) {
            const linkTopic = document.createElement("a");
            linkTopic.classList.add("is_mod");
            linkTopic.href = "/topic/" + user.id_topic;
            const n = user.id_topic;
            linkTopic.innerHTML = "Moderator of " + topics[n];
            linksDiv.appendChild(linkTopic);
        }

        if (user.type === "admin") {
            const span = document.createElement("span");
            span.classList.add("admin");
            span.textContent = "Admin";

            linksDiv.append(span);
        }

        const buttonMod = document.createElement("button");

        if (user.type !== "admin") {
            buttonMod.classList.add("text", "modBut", "button");
            if (!user.blocked && user.id_topic !== null) {
                buttonMod.addEventListener("click", function removeMod() {
                    revokeModerator(this);
                });
                buttonMod.textContent = "Revoke Moderator";
            }
            if (!user.blocked && user.id_topic === null) {
                buttonMod.addEventListener("click", function openModChoices() {
                    openMakeModeratorTopic(this);
                });
                buttonMod.textContent = "Upgrade to Moderator";
            }

            const buttonAdmin = document.createElement("button");
            buttonAdmin.classList.add("upgrade", "button");
            buttonAdmin.setAttribute("data-operation", "upgrade_user");
            if (!user.blocked && user.type !== "admin") {
                buttonAdmin.addEventListener("click", async function () {
                    const idUser = buttonAdmin.parentNode.parentNode.id;
                    upgradeUserToAdmin(
                        `/api/${buttonAdmin.dataset.operation}`,
                        idUser
                    );
                });
                buttonAdmin.textContent = "Upgrade to Administrator";
            }

            buttonsDiv.append(buttonMod, buttonAdmin, blockUnblockButton);
        }

        li.append(linksDiv, buttonsDiv);

        usersList.appendChild(li);

        if (parseInt(user_id) !== user.id && user.type !== "admin") {
            blockUnblockEventListener(
                blockUnblockButton,
                user.blocked ? "unblock" : "block"
            );
        }
    }
}

// block icon
document
    .querySelectorAll("#all_users .user button.block")
    ?.forEach((button) => {
        blockUnblockEventListener(button, "block");
    });

// unblock icon
document
    .querySelectorAll("#all_users .user button.unblock")
    ?.forEach((button) => {
        blockUnblockEventListener(button, "unblock");
    });

function blockUnblockEventListener(button, action) {
    button.addEventListener("click", async function eventHandler() {
        const method = action === "block" ? "block_user" : "unblock_user";
        const id = button.parentNode.parentNode.id;
        const name = document.querySelector(
            'li[id="' + id + '"] .name_wrapper > a'
        ).textContent;
        Swal.fire({
            title: "Do you want to " + action + " " + name + "?",
            text:
                name +
                " will " +
                (action === "block" ? "lose" : "regain") +
                " access to the account.",
            showCancelButton: true,
            confirmButtonText: action.charAt(0).toUpperCase() + action.slice(1),
            icon: "question",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                try {
                    const response = await fetch("/api/" + method, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({ request: id }),
                    });

                    return response.json();
                } catch (error) {
                    Swal.showValidationMessage(
                        `Request failed: Try again later.`
                    );
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                Swal.fire({
                    title: name + " was " + action + "ed successfully",
                    icon: "success",
                });

                button.innerHTML = action === "block" ? "Unblock" : "Block";

                button.classList.remove(
                    action === "block" ? "block" : "unblock"
                );
                button.classList.add(action === "block" ? "unblock" : "block");

                // atualiza event listener
                button.removeEventListener("click", eventHandler);
                blockUnblockEventListener(
                    button,
                    action === "block" ? "unblock" : "block"
                );

                // remove restantes botoes caso leve block
                if (action === "block") {
                    document
                        .querySelector('li[id="' + id + '"] .modBut')
                        ?.remove();
                    document
                        .querySelector('li[id="' + id + '"] .upgrade')
                        ?.remove();
                } else {
                    const buttonDiv = button.parentNode;

                    // admin button
                    const buttonAdmin = document.createElement("button");
                    buttonAdmin.classList.add("upgrade", "button");
                    buttonAdmin.setAttribute("data-operation", "upgrade_user");
                    buttonAdmin.addEventListener("click", () => {
                        upgradeUserToAdmin(
                            `/api/${buttonAdmin.dataset.operation}`,
                            id
                        );
                    });
                    buttonAdmin.textContent = "Upgrade to Administrator";

                    // mod button
                    const buttonMod = document.createElement("button");
                    buttonMod.classList.add("text", "modBut", "button");

                    const isMod =
                        document.querySelector(
                            'li[id="' + id + '"] > div:first-of-type'
                        ).children.length === 2;

                    if (isMod) {
                        buttonMod.addEventListener("click", function () {
                            revokeModerator(this);
                        });
                        buttonMod.textContent = "Revoke Moderator";
                    } else {
                        buttonMod.addEventListener("click", function () {
                            openMakeModeratorTopic(this);
                        });
                        buttonMod.textContent = "Upgrade to Moderator";
                    }

                    buttonDiv.prepend(buttonMod, buttonAdmin);
                }
            }
        });
    });
}

function upgradeUserToAdmin(url, id) {
    const name = document.querySelector(
        'li[id="' + id + '"] .name_wrapper > a'
    ).textContent;

    Swal.fire({
        title: "Do you want to upgrade " + name + " to admin?",
        text: "You won't be able to revert this acion!",
        icon: "warning",
        showCancelButton: true,
    }).then(async (response) => {
        if (response.isConfirmed) {
            const result = await sendFetchRequest(
                "POST",
                url,
                { idUser: id },
                "json"
            );
            upgradeUserHandler(result[1].id);
            Swal.fire({
                title: "Success",
                text: name + " was upgraded to admin successfully.",
                icon: "success",
            });
        }
    });
}

document.querySelectorAll(".topics_proposal button").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idTopic = button.closest("article").id;
        sendAjaxRequest(
            "post",
            `/manage_topic/${button.dataset.operation}`,
            { idTopic },
            topicProposalHandler
        );
    });
});

function topicProposalHandler() {
    //if (this.status != 200) window.location = "/";
    let idTopic = JSON.parse(this.responseText);
    let element = document.getElementById(idTopic);
    element.remove();
}

document.querySelectorAll(".upgrade").forEach((button) => {
    button.addEventListener("click", (event) => {
        const idUser = button.parentNode.parentNode.id;
        upgradeUserToAdmin(`/api/${event.target.dataset.operation}`, idUser);
    });
});

function upgradeUserHandler(id) {
    document.querySelector('li[id="' + id + '"] .block')?.remove();
    document.querySelector('li[id="' + id + '"] .modBut')?.remove();
    document.querySelector('li[id="' + id + '"] .upgrade')?.remove();
    document.querySelector('li[id="' + id + '"] .is_mod')?.remove();

    const span = document.createElement("span");
    span.classList.add("admin");
    span.textContent = "Admin";
    document
        .querySelector('li[id="' + id + '"] > div:first-of-type')
        .append(span);
}
