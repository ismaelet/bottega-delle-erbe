document.querySelectorAll(".filter-option, .sort-cbx").forEach((input) => {
  input.addEventListener("change", () => input.form.requestSubmit());
});

const filterButton = document.querySelector("#filter-text");
filterButton?.addEventListener("click", () => {
  const open = document.querySelector("#search-sec").classList.toggle("open");
  filterButton.classList.toggle("open", open);
  filterButton.setAttribute("aria-expanded", String(open));
});

document.querySelectorAll("#infos .title").forEach((button) => {
  button.addEventListener("click", () => {
    document.querySelectorAll("#infos [data-info]").forEach((element) => {
      element.classList.toggle("active", element.dataset.info === button.dataset.info);
    });
  });
});

document.querySelectorAll(".list .show-more").forEach((button) => {
  button.addEventListener("click", () => button.parentElement.classList.add("open"));
});
