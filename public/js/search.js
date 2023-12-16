"use strict";

const advanced_search_form = document.querySelector("#advanced_search_form");
advanced_search_form.addEventListener("submit", async (e) => {
    e.stopPropagation();
    e.preventDefault();

    const [response, raw_data] = await sendFetchRequest(
        "GET",
        "/news/advanced_search",
        getFormParams(advanced_search_form, false),
        "text"
    );
    window.history.pushState(raw_data, null, response.url);
    updateFeed(raw_data);
});
