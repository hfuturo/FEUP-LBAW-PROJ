"use strict";

document.querySelectorAll(".feed_button").forEach((button) => {
    button.addEventListener("click", feedLinksHandler);
});

document.querySelectorAll(".paginate a").forEach((link) => {
    link.addEventListener("click", feedLinksHandler);
});

async function feedLinksHandler(e) {
    e.preventDefault();
    e.stopPropagation();
    const response = await fetch(e.target.href);
    const raw_data = await response.text();
    updateFeed(raw_data);
    document.getElementById("content").scrollIntoView({ behavior: "smooth" });
}

function updateFeed(raw_data) {
    const all_news = document.querySelector(".all_news");
    all_news.innerHTML = raw_data;
    all_news.querySelectorAll(".paginate a").forEach((link) => {
        link.addEventListener("click", feedLinksHandler);
    });
}
