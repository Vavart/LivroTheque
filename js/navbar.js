const navLinks = document.querySelector(".nav-links");
const btnResponsiveNav = document.querySelector(".btn-responsive-nav");


window.addEventListener("resize", () => {
    if (window.innerWidth > 777) {
        navLinks.classList.remove("nav-active");
    }
})

btnResponsiveNav.addEventListener("click", () => {
    navLinks.classList.toggle("nav-active");
})