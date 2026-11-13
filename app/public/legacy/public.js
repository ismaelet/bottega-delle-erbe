const header = document.querySelector("header");
const panel = document.querySelector("#h-pan");
const mobileMenu = document.querySelector("#h-navM");
const mobileToggle = document.querySelector("#h-cbxM");
const searchToggle = document.querySelector("#h-srch-cbx");
const searchIcon = document.querySelector("#h-srch-ico");

function updateSearchIcon() {
  const white = searchToggle.checked || (header.classList.contains("dark") && !mobileToggle.checked);
  searchIcon.classList.toggle("txt-wht", white);
  searchIcon.classList.toggle("txt-3", !white);
}

function sizeHeader() {
  const height = panel.offsetHeight;
  header.style.height = `${height}px`;
  mobileMenu.style.top = `${height}px`;
  mobileMenu.style.height = `calc(100% - ${height}px)`;
  document.querySelectorAll("header .megamenu").forEach((menu) => {
    menu.style.maxHeight = `calc(100vh - ${height}px)`;
  });
}

function showMenu(menu) {
  panel.classList.add("solid");
  menu.classList.add("active");
}

function hideMenus() {
  panel.classList.remove("solid");
  document.querySelectorAll("header .megamenu").forEach((menu) => menu.classList.remove("active"));
}

document.querySelectorAll(".megamenu-open").forEach((trigger) => {
  const menu = document.getElementById(`megamenu-${trigger.dataset.megamenu}`);
  trigger.addEventListener("mouseenter", () => showMenu(menu));
  trigger.addEventListener("mouseleave", hideMenus);
});
document.querySelectorAll("header .megamenu").forEach((menu) => {
  menu.addEventListener("mouseenter", () => showMenu(menu));
  menu.addEventListener("mouseleave", hideMenus);
});
mobileToggle.addEventListener("change", () => {
  panel.classList.toggle("h-open", mobileToggle.checked);
  updateSearchIcon();
});
searchToggle.addEventListener("change", (event) => {
  updateSearchIcon();
  if (event.target.checked) document.querySelector("#h-srch-inp").focus();
});
window.addEventListener("resize", sizeHeader);
sizeHeader();
