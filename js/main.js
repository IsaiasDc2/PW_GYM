document.addEventListener("click", function (e) {
  const hamburger = e.target.closest(".hamburger");
  if (hamburger) {
    const mobileMenu = document.querySelector(".mobile-menu");
    if (mobileMenu) mobileMenu.classList.toggle("open");
  }
});

const header = document.querySelector("header");
window.addEventListener("scroll", function () {
  if (header) {
    if (window.scrollY > 40) {
      header.style.background = "rgba(8,8,8,0.95)";
      header.style.backdropFilter = "blur(12px)";
      header.style.borderBottom = "1px solid var(--border)";
    } else {
      header.style.background = "transparent";
      header.style.backdropFilter = "none";
      header.style.borderBottom = "none";
    }
  }
});