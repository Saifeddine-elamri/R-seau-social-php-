
document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navHeader = document.querySelector(".nav-header");

    menuToggle.addEventListener("click", function () {
        navHeader.classList.toggle("show");
    });

    // Fermer le menu si on clique en dehors
    document.addEventListener("click", function (event) {
        if (!menuToggle.contains(event.target) && !navHeader.contains(event.target)) {
            navHeader.classList.remove("show");
        }
    });
});