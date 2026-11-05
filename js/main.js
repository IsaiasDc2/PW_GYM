document.addEventListener("click", function (e) {
  const hamburger = e.target.closest(".hamburger");
  if (hamburger) {
    const mobileMenu = document.querySelector(".mobile-menu");
    if (mobileMenu) {
      const abierto = mobileMenu.classList.toggle("open");
      hamburger.setAttribute("aria-expanded", abierto ? "true" : "false");
    }
  }
});

document.addEventListener("submit", function (e) {
  const mensaje = e.target.getAttribute("data-confirm");
  if (mensaje && !window.confirm(mensaje)) e.preventDefault();
});

const filtro = document.getElementById("filtro");
if (filtro) {
  filtro.addEventListener("change", function () {
    const valor = filtro.value;
    document.querySelectorAll("[data-categoria]").forEach(function (el) {
      el.style.display = valor === "" || el.getAttribute("data-categoria") === valor ? "" : "none";
    });
  });
}

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
