document.addEventListener("DOMContentLoaded", () => {
    const hamburger = document.querySelector(".menu-hamburger");
    const mobileMenu = document.querySelector(".mobile-menu");

    if (hamburger && mobileMenu) {
        hamburger.addEventListener("click", () => {
            mobileMenu.classList.toggle("active");
        });
    }
});
