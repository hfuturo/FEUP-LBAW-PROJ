"use strict";

const all_news = document.querySelector(".all_news");

document.querySelectorAll(".feed_button").forEach((button) => {
    button.addEventListener("click", feedLinksHandler);
});

document.querySelectorAll(".paginate a").forEach((link) => {
    link.addEventListener("click", feedLinksHandler);
});

async function feedLinksHandler(e) {
    e.preventDefault();
    e.stopPropagation();

    const link = e.target.closest("a");

    const [response, raw_data] = await sendFetchRequest(
        "GET",
        link.href,
        null,
        "text"
    );
    window.history.pushState(raw_data, "", response.url);
    updateFeed(raw_data);
    document.getElementById("content").scrollIntoView({ behavior: "smooth" });
}

function updateFeed(raw_data) {
    all_news.innerHTML = raw_data;
    all_news.querySelectorAll(".paginate a").forEach((link) => {
        link.addEventListener("click", feedLinksHandler);
    });
}

window.addEventListener("popstate", (event) => {
    if (event.state) updateFeed(event.state);
});
