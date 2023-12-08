"use strict";

const filterUsersInput = document.querySelector("#users input");
filterUsersInput.addEventListener("input", async function () {
    sendAjaxRequest(
        "post",
        "/api/manage",
        { search: filterUsersInput.value },
        filterUsersHandler
    );
});

function filterUsersHandler() {
    if (this.status != 200) window.location = "/";
    const users = JSON.parse(this.responseText);

    let usersList = document.querySelector("#all_users");

    // limpa a lista
    usersList.innerHTML = "";

    // reconstroi lista
    for (const user of users) {
        let li = document.createElement("li");
        li.classList.add("user");
        let link = document.createElement("a");
        link.href = "/profile/" + user.id;
        link.innerHTML = user.name;
        li.appendChild(link);
        usersList.appendChild(li);
    }
}
