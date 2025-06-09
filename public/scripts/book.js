document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".availability-list button");

    buttons.forEach((button) => {
        button.addEventListener("click", async (e) => {
            const li = e.target.closest("li");
            const libraryName = li.querySelector("h3").innerText;

            const response = await fetch("/reserve", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    bookId: new URLSearchParams(window.location.search).get(
                        "id"
                    ),
                    library: libraryName,
                }),
            });

            const result = await response.json();
            alert(result.message);
        });
    });
});
