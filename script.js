const products = [
  { name: "Կոկտեյլ", type: "խմիչքներ", image: "images/food/cocktail.jpg" link: "recipe2.html" },
  { name: "Բրուսկետա", type: "նախուտեստներ", image: "images/food/bruschetta.jpg" },
  { name: "Կեսար աղցան", type: "աղցաններ", image: "images/food/salad.jpg" },
  { name: "Խաշ", type: "տաքուտեստներ", image: "images/food/khash.jpg" },
  { name: "Սուրճ", type: "խմիչքներ", image: "images/food/coffee.jpg" },
];

const cardContainer = document.getElementById("card-container");
const typeFilters = document.querySelectorAll(".type-filter");

function renderCards() {
  const activeTypes = Array.from(typeFilters)
    .filter(cb => cb.checked)
    .map(cb => cb.value);

  cardContainer.innerHTML = "";

  products.forEach(p => {
    if (activeTypes.includes(p.type)) {
      const card = document.createElement("div");
      card.className = "card";

      const img = document.createElement("img");
      img.src = p.image;
      img.alt = p.name;

      const title = document.createElement("div");
      title.textContent = p.name;

      card.appendChild(img);
      card.appendChild(title);
      cardContainer.appendChild(card);
    }
  });

  const btn = document.createElement("a");
  btn.href = p.link;
  btn.className = "btn green";
  btn.textContent = "Կարդալ ավելին";
  cardContent.appendChild(btn);

}

typeFilters.forEach(cb => {
  cb.addEventListener("change", renderCards);
});

renderCards();
