"use strict";

const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data)
        .map(function (k) {
            return encodeURIComponent(k) + "=" + encodeURIComponent(data[k]);
        })
        .join("&");
}

function getFormParams(form, keepEmpty = true) {
    let entries = [...new FormData(form).entries()];
    if (!keepEmpty)
        entries = entries.filter(([name, value]) => {
            return value !== "";
        });
    return Object.fromEntries(entries);
}

async function sendFetchRequest(method, url, data, convert = null) {
    method = method.toUpperCase();
    url = new URL(url, location);
    let response;
    if (method === "GET") {
        if (data)
            Object.keys(data).forEach((k) => {
                url.searchParams.set(k, data[k]);
            });
        response = await fetch(url, {
            method,
            cache: "no-store",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });
    } else {
        response = await fetch(url, {
            method,
            cache: "no-store",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });
    }
    if (convert === "text") {
        return [response, await response.text()];
    } else if (convert === "json") {
        return [response, await response.json()];
    }
    return [response, null];
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();

    request.open(method, url, true);
    request.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
    );
    request.addEventListener("load", handler);
    request.send(encodeForAjax(data));
}

function removeById(array, id) {
    for (let i = 0; i < array.length; i++) {
        if (array[i].id == id) {
            array.splice(i, 1);
        }
    }
}
