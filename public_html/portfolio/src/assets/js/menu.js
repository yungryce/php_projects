const menuToggle = document.getElementById("menu-toggle");
const menuClose = document.getElementById("menu-close");
const menu = document.getElementById("menu");

// Toggle menu visibility
function toggleMenu() {
    menuToggle.classList.toggle("hidden");
    menuClose.classList.toggle("hidden");
    menu.classList.toggle("hidden");
}

menuToggle.addEventListener("click", toggleMenu);
menuClose.addEventListener("click", toggleMenu);

document.body.addEventListener("click", function (event) {
    const isMenuClicked = menu.contains(event.target);
    const isMenuToggleClicked = menuToggle.contains(event.target);

    if (!isMenuClicked && !isMenuToggleClicked) {
        menuToggle.classList.remove("hidden");
        menuClose.classList.add("hidden");
        menu.classList.add("hidden");
    }
});