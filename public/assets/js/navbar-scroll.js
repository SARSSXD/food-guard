document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("mainNavbar");
    const mainPanel = document.querySelector(".main-panel");

    function toggleNavbar() {
        if (mainPanel.scrollTop > 0) {
            navbar.classList.remove("navbar-static");
            navbar.classList.add("navbar-fixed");
        } else {
            navbar.classList.remove("navbar-fixed");
            navbar.classList.add("navbar-static");
        }
    }

    // Run on initial load
    toggleNavbar();

    // Run on scroll
    mainPanel.addEventListener("scroll", toggleNavbar);
});
