function revokeModerator(button) {
    closeMakeModeratorTopic();
    const userLi = button.parentNode.parentNode;
    const userId = userLi.getAttribute("id");
    const name = document.querySelector(
        'li[id="' + userId + '"] .name_wrapper > a'
    ).textContent;
    Swal.fire({
        title: "Are you sure?",
        text: name + " won't be able to moderate the topic anymore.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, revoke his provileges!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const data = await sendFetchRequest(
                    "PATCH",
                    "/api/moderator/revoke",
                    { id: userId },
                    "json"
                );

                const result = data[1];

                if (result.success) {
                    let buttonMod = userLi.querySelector(".modBut");
                    buttonMod.onclick = function () {
                        openMakeModeratorTopic(this);
                    };
                    userLi.querySelector(".is_mod").remove();
                    button.textContent = "Upgrade to Moderator";
                    Swal.fire({
                        title: "Revoked privileges!",
                        text: name + " is not a moderator anymore.",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                } else {
                    Swal.fire({
                        title: "Fail!",
                        text: result.error,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`
                Request failed: ${error}
              `);
            }
        }
    });
}

function revokeModerator2(button) {
    const user = button.parentNode;
    const userId = user.getAttribute("id");
    const name = document.querySelector(
        'li[id="' + userId + '"]  > a'
    ).textContent;
    Swal.fire({
        title: "Are you sure?",
        text: name + " won't be able to moderate the topic anymore.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, revoke his provileges!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const result = await fetch("/api/moderator/revoke", {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({ id: userId }),
                }).then((response) => response.json());

                if (result.success) {
                    const topic = user.closest("article");
                    const nMods = topic.querySelector(".nMods");
                    const value = parseInt(nMods.getAttribute("value"));
                    let n = value - 1;
                    nMods.setAttribute("value", n);
                    nMods.textContent = "(" + n + ")";
                    if (n === 0) {
                        const ul = user.parentNode;
                        const li = document.createElement("li");
                        li.textContent = "This topic has no moderators";
                        ul.appendChild(li);
                    }
                    user.remove();

                    const newOption = document.createElement("option");
                    newOption.setAttribute("value", userId);
                    const name = user.querySelector("a").textContent;
                    newOption.textContent = name;
                    const options = formUser.querySelector("#select_user");
                    options.appendChild(newOption);

                    Swal.fire({
                        title: "Revoked privileges!",
                        text: name + " is not a moderator anymore.",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    });
                } else {
                    Swal.fire({
                        title: "Fail!",
                        text: result.error,
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                    });
                }
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`
                Request failed: ${error}
              `);
            }
        }
    });
}

const popup = document.getElementById("topic_list_popup");
const formTopic = document.getElementById("choose_topic_form");
const inputId = document.querySelector("#id_user");

function openMakeModeratorTopic(button) {
    const idUser = button.parentNode.parentNode.getAttribute("id");
    inputId.value = idUser;
    popup.style.display = "block";
}

function closeMakeModeratorTopic() {
    inputId.value = "";
    popup.style.display = "none";
}

document
    .querySelector("#choose_topic_form")
    ?.addEventListener("submit", async function (event) {
        event.preventDefault();

        const name = document.querySelector(
            'li[id="' + inputId.value + '"] .name_wrapper > a'
        ).textContent;

        const topic = formTopic.querySelector("#select_topic");

        const data = {
            user: inputId.value,
            topic: topic.value,
        };
        Swal.fire({
            title: "Are you sure?",
            text: name + " will be able to moderate this topic.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, made it moderator!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await sendFetchRequest(
                        "PATCH",
                        "/api/moderator/make",
                        data,
                        "json"
                    );

                    result = response[1];

                    if (result.success) {
                        const userLi = document.getElementById(inputId.value);
                        let button = userLi.querySelector(".modBut");
                        button.onclick = function () {
                            revokeModerator(this);
                        };
                        button.textContent = "Revoke Moderator";
                        Swal.fire({
                            title: name + " is a moderator now!",
                            text: result.success,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        });
                        const div = userLi.querySelector("div:first-of-type");
                        const newA = document.createElement("a");
                        newA.classList.add("is_mod");
                        newA.href = "/topic/" + topic.value;
                        const selectedIndex = topic.selectedIndex;
                        const topicName =
                            topic.options[selectedIndex].textContent;
                        newA.textContent = "Moderator of " + topicName;
                        div.append(newA);
                    } else {
                        Swal.fire({
                            title: "Fail!",
                            text: result.error,
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                        });
                    }
                    closeMakeModeratorTopic();
                } catch (error) {
                    console.error("Error:", error);
                    Swal.showValidationMessage(`
                Request failed: ${error}
              `);
                }
            }
        });
    });

const popupUser = document.getElementById("list_users_popup");
const formUser = document.getElementById("choose_user_form");
const inputTopic = document.querySelector("#id_topic");

function openMakeModeratorUser(button) {
    const idTopic = button.parentNode.parentNode.getAttribute("id-topic");
    inputTopic.value = idTopic;
    popupUser.style.display = "block";
}

function closeMakeModeratorUser() {
    inputTopic.value = "";
    popupUser.style.display = "none";
}

document
    .querySelector("#choose_user_form")
    ?.addEventListener("submit", async function (event) {
        event.preventDefault();

        const user = formUser.querySelector("#select_user");
        const userID = user.value;
        const name = document.querySelector(
            '#select_user option[value="' + userID + '"]'
        ).textContent;
        const data = {
            user: userID,
            topic: inputTopic.value,
        };
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            text: name + " will be able to moderate this topic.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, made it moderator!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    const response = await sendFetchRequest(
                        "PATCH",
                        "/api/moderator/make",
                        data,
                        "json"
                    );
                    const result = response[1];

                    if (result.success) {
                        const topic = document.querySelector(
                            `article[id-topic ="${inputTopic.value}"]`
                        );
                        const ul = topic.querySelector("ul");
                        const nMods = topic.querySelector(".nMods");
                        const value = parseInt(nMods.getAttribute("value"));
                        if (value === 0) {
                            ul.firstElementChild.remove();
                        }
                        let n = value + 1;
                        nMods.setAttribute("value", n);
                        nMods.textContent = "(" + n + ")";
                        const li = document.createElement("li");
                        li.className = "moderator";
                        li.setAttribute("id", userID);

                        const index = user.selectedIndex;
                        const userName = user.options[index].textContent;
                        const link = document.createElement("a");
                        link.href = "/profile/" + userID;
                        link.textContent = userName;
                        li.appendChild(link);

                        const button = document.createElement("button");
                        button.classList = "button";
                        button.onclick = function () {
                            revokeModerator2(this);
                        };
                        button.textContent = "Revoke privileges";

                        li.appendChild(button);
                        ul.appendChild(li);

                        user.querySelector(
                            `option[value ="${userID}"]`
                        ).remove();

                        Swal.fire({
                            title: name + " is a moderador now!",
                            text: result.success,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                        });
                    } else {
                        Swal.fire({
                            title: "Fail!",
                            text: result.error,
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                        });
                    }
                    closeMakeModeratorUser();
                } catch (error) {
                    console.error("Error:", error);
                    Swal.showValidationMessage(`
                Request failed: ${error}
              `);
                }
            }
        });
    });
