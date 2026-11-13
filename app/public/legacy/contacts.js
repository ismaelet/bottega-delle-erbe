document.querySelectorAll("#form .form-inp, #form .form-textarea").forEach((input) => {
  const label = input.previousElementSibling;
  const update = () =>
    label.classList.toggle("focus", document.activeElement === input || input.value.length > 0);

  input.addEventListener("focus", () => label.classList.add("focus"));
  input.addEventListener("blur", update);
  input.addEventListener("input", update);
  update();
});
