$(document).ready(function () {
    document.getElementById("menuToggle").addEventListener("click", function () {
        const menu = document.getElementById("mobileMenu");
        menu.classList.toggle("show");
    });
});