document.addEventListener("DOMContentLoaded", () => {
    const searchInputs = document.querySelectorAll(".search-bar");
    const isMobile = window.innerWidth <= 768;
    let currentPage = 1;

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param) || "";
    }

    function fetchBooks(page = 1, search = "") {
        const category = getQueryParam("category");
        fetch("/books", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ page, search, category }),
        })
            .then((res) => res.json())
            .then((data) => {
                renderBooks(data.books, data.currentPage, data.totalPages);
                currentPage = data.currentPage;
            });
    }

    function renderBooks(books, currentPage, totalPages) {
        const tbody = document.querySelector(".books-table tbody");
        tbody.innerHTML = "";

        if (books.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5">No books found.</td></tr>';
            return;
        }

        books.forEach((book, index) => {
            const row = document.createElement("tr");
            if (book.quantity == 0) row.classList.add("out-of-stock");
            row.onclick = () => {
                window.location.href = `/book?id=${book.id}`;
            };

            row.innerHTML = `
                <td>${(currentPage - 1) * 15 + index + 1}</td>
                <td>${book.title}</td>
                <td>${book.author}</td>
                <td>${book.category}</td>
                <td>${book.quantity}</td>
            `;
            tbody.appendChild(row);
        });

        const pagination = document.querySelector(".pagination");
        if (!pagination) return;

        pagination.innerHTML = "";
        if (currentPage > 1) {
            pagination.innerHTML += `<a href="#" data-page="${
                currentPage - 1
            }" class="pagination-btn">Previous</a>`;
        }
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                pagination.innerHTML += `<span class="pagination-active">${i}</span>`;
            } else {
                pagination.innerHTML += `<a href="#" data-page="${i}" class="pagination-btn">${i}</a>`;
            }
        }
        if (currentPage < totalPages) {
            pagination.innerHTML += `<a href="#" data-page="${
                currentPage + 1
            }" class="pagination-btn">Next</a>`;
        }
    }

    document.querySelector(".pagination")?.addEventListener("click", (e) => {
        if (e.target.matches(".pagination-btn")) {
            e.preventDefault();
            const page = parseInt(e.target.dataset.page);
            if (isMobile) {
                fetchBooks(page, searchInputs[1].value);
            } else {
                fetchBooks(page, searchInputs[0].value);
            }
        }
    });

    searchInputs.forEach((input) => {
        input.addEventListener("input", () => {
            const value = input.value;
            searchInputs.forEach((i) => {
                if (i !== input) i.value = value; // synchronizacja inputów
            });
            fetchBooks(1, value);
        });
    });

    fetchBooks();
});
