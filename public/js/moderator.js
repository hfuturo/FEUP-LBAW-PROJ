function revokeModerator(button) {
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

function openMakeModeratorTopic(button) {
    const idUser = button.parentNode.parentNode.getAttribute("id");
    openMakeModeratorTopicForm(idUser);
}

async function makeModeratorSubmit(id, data, topicName) {
    const name = document.querySelector(
        'li[id="' + id + '"] .name_wrapper > a'
    ).textContent;

    Swal.fire({
        title: "Are you sure?",
        text: name + " will be able to moderate this topic.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, made it moderator!",
    }).then(async (res) => {
        if (res.isConfirmed) {
            try {
                const [response, result] = await sendFetchRequest(
                    "PATCH",
                    "/api/moderator/make",
                    data,
                    "json"
                );

                if (result.success) {
                    const userLi = document.getElementById(id);
                    let button = userLi.querySelector(".modBut");
                    button.onclick = function () {
                        revokeModerator(button);
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
                    newA.href = "/topic/" + data.topic;
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
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        }
    });
}

function openMakeModeratorUser(button) {
    const idTopic = button.parentNode.parentNode.getAttribute("id-topic");
    openAddModeratorTopicForm(idTopic);
}

async function makeModerator2Submit(data, name) {
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
                        `article[id-topic ="${data.topic}"]`
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
                    li.setAttribute("id", data.user);

                    const link = document.createElement("a");
                    link.href = "/profile/" + data.user;
                    link.textContent = name;
                    li.appendChild(link);

                    const button = document.createElement("button");
                    button.classList = "button";
                    button.onclick = function () {
                        revokeModerator2(this);
                    };
                    button.textContent = "Revoke privileges";

                    li.appendChild(button);
                    ul.appendChild(li);

                    removeById(allUsers, data.user);

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
            } catch (error) {
                console.error("Error:", error);
                Swal.showValidationMessage(`Request failed: ${error}`);
            }
        }
    });
}
