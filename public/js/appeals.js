"use strict";

document
    .querySelectorAll("#container_choices button.reject_appeal")
    ?.forEach((button) => {
        button.addEventListener("click", () => {
            const name =
                button.parentNode.previousElementSibling.previousElementSibling
                    .children[0].textContent;
            const id =
                button.parentNode.previousElementSibling.previousElementSibling
                    .id;
            Swal.fire({
                title: "Do you want to reject this appeal from " + name + "?",
                text: "If you reject this appeal, " + name + " will be banned.",
                showCancelButton: true,
                showConfirmButton: false,
                showDenyButton: true,
                denyButtonText: "Reject",
                icon: "question",
                showLoaderOnDeny: true,
                preDeny: async () => {
                    try {
                        await fetch("/api/reject_appeal", {
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
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isDenied) {
                    Swal.fire({
                        title: name + " was banned successfully",
                        icon: "success",
                    });

                    removeAppeal(button);
                }
            });
        });
    });

document
    .querySelectorAll("#container_choices button.unblock_user")
    ?.forEach((button) => {
        button.addEventListener("click", () => {
            const name =
                button.parentNode.previousElementSibling.previousElementSibling
                    .children[0].textContent;
            const id =
                button.parentNode.previousElementSibling.previousElementSibling
                    .id;
            const result = Swal.fire({
                title: "Do you want to unblock " + name + "?",
                showCancelButton: true,
                confirmButtonText: "Unblock",
                icon: "question",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch("/api/unblock_user", {
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
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: name + " was unblocked successfully",
                        icon: "success",
                    });

                    removeAppeal(button);
                }
            });
        });
    });

function removeAppeal(button) {
    button.parentNode.previousElementSibling.parentNode.remove();
    const section = document.getElementById("list_unblock_appeals");
    if (section.children.length <= 1) {
        section.textContent = "There are no unblock appeals to show.";
    }
}
