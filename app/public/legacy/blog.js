const grid = document.querySelector("[data-blog-posts]");
const posts = Array.from(grid.querySelectorAll(".post"));

function organizePosts() {
  grid.style.height = "";
  posts.forEach((post) => {
    post.classList.remove("big");
    post.style.top = "";
  });

  if (!posts.length || window.innerWidth <= 480) return;

  const width = window.innerWidth;
  const columns = width <= 768 ? 2 : width <= 1440 ? 3 : 4;
  const imageHeight = posts[0].querySelector(".image").offsetHeight;

  posts.forEach((post, index) => {
    const id = index + 1;
    const row = Math.ceil(id / columns);
    if (columns % 2 === 0 ? (id + row) % 2 : id % 2) post.classList.add("big");
    if (id % 2 && row > 1) post.style.top = `${-imageHeight * Math.floor(row / 2)}px`;
    else if (id % 2 === 0 && row > 2) post.style.top = `${-imageHeight * Math.floor((row - 1) / 2)}px`;
  });

  const bottom = Math.max(...posts.map((post) => post.offsetTop + post.offsetHeight));
  grid.style.height = `${bottom}px`;
}

window.addEventListener("resize", organizePosts);
organizePosts();
