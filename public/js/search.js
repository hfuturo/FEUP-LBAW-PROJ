"use strict";

const advanced_search_form = document.querySelector("#advanced_search_form");
advanced_search_form.reset();
advanced_search_form.addEventListener("submit", async (e) => {
    e.stopPropagation();
    e.preventDefault();

    createTags();
    tagInput.value = tagContainer.textContent.trim();
    while (tagContainer.firstChild !== tagInput) {
        tagContainer.firstChild.remove();
    }
    const data = getFormParams(advanced_search_form, false);
    createTags();

    const [response, raw_data] = await sendFetchRequest(
        "GET",
        "/news/advanced_search",
        data,
        "text"
    );

    window.history.pushState(raw_data, "", response.url);
    updateFeed(raw_data);
});

document.querySelectorAll("select").forEach((select) => {
    if (select.value === "") {
        select.style.color = "#767676";
    } else {
        select.style.color = "";
    }
    select.addEventListener("change", (e) => {
        if (select.value === "") {
            select.style.color = "#767676";
        } else {
            select.style.color = "";
        }
    });
});
