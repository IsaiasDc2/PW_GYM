document.addEventListener("click", function (e) {
  const hamburger = e.target.closest(".hamburger");
  if (hamburger) {
    const mobileMenu = document.querySelector(".mobile-menu");
    if (mobileMenu) {
      mobileMenu.classList.toggle("open");
      const open = mobileMenu.classList.contains("open");
      hamburger.setAttribute("aria-expanded", open ? "true" : "false");
    }
  }
});

const header = document.querySelector(".site-header");
window.addEventListener("scroll", function () {
  if (!header) return;
  if (window.scrollY > 40) {
    header.style.background = "rgba(8,8,8,0.95)";
  } else {
    header.style.background = "rgba(8,8,8,0.95)";
  }
});
