function revealVisible() {
  document.querySelectorAll(".load").forEach((element) => {
    if (element.getBoundingClientRect().top <= window.innerHeight) {
      element.classList.remove("load");
    }
  });
}

function resizeHome() {
  document.querySelector("#slider").style.height = `${window.innerHeight}px`;
  document.querySelectorAll(".about-txt").forEach((text) => {
    text.parentElement.style.maxHeight = `${text.offsetHeight}px`;
  });
  revealVisible();
}

document.querySelectorAll(".read-more").forEach((button) => {
  button.addEventListener("click", () => {
    const text = button.closest(".about-row").querySelector(".about-txt");
    text.classList.add("open");
    text.parentElement.style.maxHeight = `${text.offsetHeight}px`;
    button.style.display = "none";
  });
});

let bioIndex = 1;
let shopIndex = 1;
setInterval(() => {
  bioIndex = (bioIndex % 3) + 1;
  shopIndex = (shopIndex % 4) + 1;
  document.querySelectorAll(".about-bio-img, .about-shop-img").forEach((image) => image.classList.remove("active"));
  document.querySelector(`#about-bio-img${bioIndex}`).classList.add("active");
  document.querySelector(`#about-shop-img${shopIndex}`).classList.add("active");
}, 6000);

window.addEventListener("scroll", revealVisible, { passive: true });
window.addEventListener("resize", resizeHome);
window.addEventListener("load", resizeHome);
resizeHome();
