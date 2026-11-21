"use strict";

const pets = [
  {
    name: "Pomeranian",
    category: "Dogs",
    emoji: "🐕",
    image: "pomeranian.jpg",
    description: "Pomeranians are small, fluffy dogs that are playful, intelligent, and friendly.",
    characteristics: "Friendly, intelligent, playful, alert",
    lifespan: "12–16 years",
    size: "Small",
    diet: "High-quality small-breed dog food suited to age and activity; fresh water.",
    care: "Daily walks, playtime, companionship, positive training, frequent brushing, dental care, and routine veterinary checkups.",
    detail: "Pomeranians originated in the Pomerania region and are known for their fluffy double coats and lively personalities."
  },
  {
    name: "Shiba Inu",
    category: "Dogs",
    emoji: "🐶",
    image: "shiba_inu.jpg",
    description: "Shiba Inus are small-to-medium dogs known for their fox-like appearance and independent personality.",
    characteristics: "Loyal, alert, intelligent, independent",
    lifespan: "12–15 years",
    size: "Medium",
    diet: "High-quality dog food suited to age and activity; fresh water.",
    care: "Daily exercise, regular brushing, positive training, socialisation, companionship, and routine veterinary care.",
    detail: "Shiba Inus originated in Japan and are among the oldest native Japanese dog breeds."
  },
  {
    name: "Scottish Fold",
    category: "Cats",
    emoji: "🐈",
    image: "scottish_fold.jpg",
    description: "Scottish Folds are friendly cats known for their unique folded ears and round faces.",
    characteristics: "Affectionate, calm, intelligent, gentle",
    lifespan: "11–14 years",
    size: "Medium",
    diet: "High-quality cat food suited to age and activity; fresh water.",
    care: "Regular grooming, daily playtime, companionship, ear cleaning when needed, and routine veterinary checkups.",
    detail: "Scottish Folds are known for their folded ears. Prospective owners should obtain a healthy cat from a reputable breeder or adoption source."
  },
  {
    name: "Munchkin Cat",
    category: "Cats",
    emoji: "🐱",
    image: "munchkin.jpg",
    description: "Munchkin cats are small cats known for their short legs and playful personalities.",
    characteristics: "Playful, friendly, affectionate, curious",
    lifespan: "12–15 years",
    size: "Small",
    diet: "High-quality cat food suited to age and activity; fresh water.",
    care: "Regular grooming, daily playtime, companionship, and routine veterinary checkups.",
    detail: "Munchkin cats are famous for their naturally short legs. They still need climbing safety, exercise, and regular health monitoring."
  },
  {
    name: "Holland Lop",
    category: "Rabbits",
    emoji: "🐰",
    image: "holland_lop.jpg",
    description: "Holland Lops are small rabbits known for their floppy ears and friendly personalities.",
    characteristics: "Gentle, playful, friendly, affectionate",
    lifespan: "7–12 years",
    size: "Small",
    diet: "Unlimited hay, fresh vegetables, a small amount of rabbit pellets, and clean drinking water.",
    care: "Daily exercise, regular brushing, clean living space, nail trimming, companionship, and rabbit-savvy veterinary care.",
    detail: "Holland Lops originated in the Netherlands. Rabbits need room to hop and spend time with appropriate companions or people."
  },
  {
    name: "French Lop",
    category: "Rabbits",
    emoji: "🐇",
    image: "french_lop.jpg",
    description: "French Lops are large rabbits known for their floppy ears and calm personalities.",
    characteristics: "Gentle, friendly, calm, affectionate",
    lifespan: "5–8 years",
    size: "Large",
    diet: "Unlimited hay, fresh vegetables, a small amount of rabbit pellets, and clean drinking water.",
    care: "Spacious living area, daily exercise, regular brushing, nail trimming, companionship, and veterinary care.",
    detail: "French Lops originated in France and are known for their large bodies, broad heads, and long drooping ears."
  },
  {
    name: "Budgerigar",
    category: "Birds",
    emoji: "🦜",
    image: "Budgerigar.jpg",
    description: "Budgerigars are small, colourful parrots known for their cheerful nature and ability to mimic sounds.",
    characteristics: "Social, playful, intelligent, active",
    lifespan: "7–10 years",
    size: "Small",
    diet: "Balanced pellets, fresh vegetables, limited seeds, and clean drinking water.",
    care: "A spacious cage, daily exercise, toys, social interaction, regular cleaning, and avian veterinary care.",
    detail: "Budgerigars originated in Australia and are popular for their colourful feathers and ability to learn simple words."
  },
  {
    name: "Cockatiel",
    category: "Birds",
    emoji: "🐤",
    image: "Cockatiel.jpg",
    description: "Cockatiels are friendly parrots known for their crests, colourful cheeks, and whistling abilities.",
    characteristics: "Friendly, social, intelligent, affectionate",
    lifespan: "15–20 years",
    size: "Medium",
    diet: "Balanced pellets, fresh vegetables, limited seeds, and clean drinking water.",
    care: "A spacious cage, daily exercise, toys, social interaction, feather care, and routine avian checkups.",
    detail: "Cockatiels originated in Australia and are known for their distinctive head crests and orange cheek patches."
  },
  {
    name: "Betta",
    category: "Fish",
    emoji: "🐠",
    image: "betta_fish.jpg",
    description: "Betta fish are colourful freshwater fish known for their beautiful flowing fins.",
    characteristics: "Territorial, active, curious, independent",
    lifespan: "3–5 years",
    size: "Small",
    diet: "High-quality betta pellets and suitable frozen or live foods.",
    care: "A heated, filtered and cycled aquarium, clean water, regular water changes, and suitable hiding places.",
    detail: "Siamese fighting fish originated in Southeast Asia. Male bettas are normally housed separately and aquariums should be kept cycled and warm."
  },
  {
    name: "Goldfish",
    category: "Fish",
    emoji: "🐟",
    image: "Goldfish.jpg",
    description: "Goldfish are popular freshwater fish known for their bright colour and graceful swimming.",
    characteristics: "Peaceful, active, social, curious",
    lifespan: "10–15+ years",
    size: "Small to large",
    diet: "Quality goldfish food in small portions.",
    care: "A spacious aquarium, proper filtration, regular water changes, good water quality, and a balanced diet.",
    detail: "Goldfish originated in China and are domesticated freshwater fish with many body shapes and sizes."
  },
  {
    name: "Golden Hamster",
    category: "Hamsters",
    emoji: "🐹",
    image: "golden_hamster.jpg",
    description: "Golden hamsters are small rodents known for their golden-brown coats and cheek pouches.",
    characteristics: "Curious, active, independent, gentle",
    lifespan: "2–3 years",
    size: "Medium",
    diet: "Balanced hamster mix, small amounts of fresh vegetables, and clean water.",
    care: "A spacious cage, exercise wheel, deep bedding, hiding places, regular cleaning, and gentle handling.",
    detail: "Golden or Syrian hamsters originate from Syria and should generally live alone."
  },
  {
    name: "Winter White Dwarf Hamster",
    category: "Hamsters",
    emoji: "🐹",
    image: "winter_white.jpg",
    description: "Winter White dwarf hamsters are tiny rodents known for changing coat colour during winter.",
    characteristics: "Friendly, active, curious, gentle",
    lifespan: "1.5–2 years",
    size: "Small",
    diet: "Balanced hamster pellets, small amounts of fresh vegetables, and clean water.",
    care: "A spacious cage, exercise wheel, deep bedding, hiding places, regular cleaning, and gentle handling.",
    detail: "Winter White dwarf hamsters originated in Siberia and surrounding regions."
  }
];

const petGrid = document.querySelector("#pet-grid");
const searchInput = document.querySelector("#pet-search");
const categoryFilter = document.querySelector("#category-filter");
const noResults = document.querySelector("#no-results");
const resultsCount = document.querySelector("#results-count");
const dialog = document.querySelector("#pet-dialog");

const csrfToken =
  document.querySelector('meta[name="csrf-token"]')?.content || "";
const favouriteSlugs = new Set();

function imageUrl(filename) {
  return `images/${filename}`;
}

function petSlug(name) {
  return name
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-|-$/g, "");
}

async function loadFavourites() {
  try {
    const response = await fetch("api/favorites.php");

    if (response.ok) {
      const data = await response.json();
      data.favorites.forEach((slug) => favouriteSlugs.add(slug));
    }
  } catch (error) {
    console.error("Could not load favourites:", error);
  }

  renderPets();
}

function renderPets() {
  if (!petGrid) return;

  const search = searchInput.value.trim().toLowerCase();
  const category = categoryFilter.value;

  const filtered = pets.filter((pet) => {
    const matchesSearch =
      `${pet.name} ${pet.category} ${pet.description}`
        .toLowerCase()
        .includes(search);

    return (
      matchesSearch &&
      (category === "all" || pet.category === category)
    );
  });

  petGrid.innerHTML = filtered
    .map((pet) => {
      const index = pets.indexOf(pet);
      const slug = petSlug(pet.name);
      const isFavourite = favouriteSlugs.has(slug);

      return `
        <article class="pet-card">
          <div class="pet-image-wrap">
            <img src="${imageUrl(pet.image)}" alt="${pet.name}" loading="lazy">
            <span class="pet-category">${pet.category}</span>
          </div>

          <div class="pet-card-body">
            <h3>${pet.emoji} ${pet.name}</h3>
            <p>${pet.description}</p>

            <dl class="pet-facts">
              <div>
                <dt>Size</dt>
                <dd>${pet.size}</dd>
              </div>
              <div>
                <dt>Lifespan</dt>
                <dd>${pet.lifespan}</dd>
              </div>
            </dl>

            <button
              class="text-button learn-more"
              type="button"
              data-index="${index}">
              Learn more <span aria-hidden="true">→</span>
            </button>

            <button
              class="favorite-button ${isFavourite ? "is-favorite" : ""}"
              type="button"
              data-favorite-slug="${slug}"
              aria-pressed="${isFavourite}">
              ${isFavourite ? "♥ Saved" : "♡ Add to favourites"}
            </button>
          </div>
        </article>
      `;
    })
    .join("");

  noResults.hidden = filtered.length !== 0;
  resultsCount.textContent =
    `${filtered.length} ${filtered.length === 1 ? "pet" : "pets"} shown`;
}

function showPetDetails(index) {
  const pet = pets[index];
  if (!pet) return;

  document.querySelector("#dialog-content").innerHTML = `
    <img class="dialog-image"
         src="${imageUrl(pet.image)}"
         alt="${pet.name}">

    <p class="eyebrow">${pet.category}</p>
    <h2 id="dialog-title">${pet.emoji} ${pet.name}</h2>
    <p>${pet.detail}</p>

    <dl class="dialog-facts">
      <div>
        <dt>Characteristics</dt>
        <dd>${pet.characteristics}</dd>
      </div>
      <div>
        <dt>Average lifespan</dt>
        <dd>${pet.lifespan}</dd>
      </div>
      <div>
        <dt>Typical size</dt>
        <dd>${pet.size}</dd>
      </div>
      <div>
        <dt>Diet</dt>
        <dd>${pet.diet}</dd>
      </div>
      <div>
        <dt>Care requirements</dt>
        <dd>${pet.care}</dd>
      </div>
    </dl>
  `;

  dialog.showModal();
}

if (petGrid) {
  petGrid.addEventListener("click", async (event) => {
    const favouriteButton = event.target.closest("[data-favorite-slug]");
    const learnButton = event.target.closest(".learn-more");

    if (learnButton) {
      showPetDetails(Number(learnButton.dataset.index));
      return;
    }

    if (!favouriteButton) return;

    const slug = favouriteButton.dataset.favoriteSlug;
    const shouldFavourite = !favouriteSlugs.has(slug);

    try {
      const response = await fetch("api/favorites.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-Token": csrfToken
        },
        body: JSON.stringify({
          slug,
          favorite: shouldFavourite
        })
      });

      if (response.status === 401) {
        window.location.href = "login.php";
        return;
      }

      const result = await response.json();

      if (!response.ok) {
        throw new Error(result.error || "Could not update favourite.");
      }

      if (shouldFavourite) {
        favouriteSlugs.add(slug);
      } else {
        favouriteSlugs.delete(slug);
      }

      renderPets();
    } catch (error) {
      alert(error.message || "Could not update favourite.");
    }
  });
}

if (dialog) {
  document.querySelector(".dialog-close")?.addEventListener("click", () => {
    dialog.close();
  });

  dialog.addEventListener("click", (event) => {
    if (event.target === dialog) {
      dialog.close();
    }
  });
}

searchInput?.addEventListener("input", renderPets);

categoryFilter?.addEventListener("change", () => {
  document.querySelectorAll(".category-pill").forEach((pill) => {
    pill.classList.toggle(
      "active",
      pill.dataset.category === categoryFilter.value
    );
  });

  renderPets();
});

document.querySelectorAll(".category-pill").forEach((pill) => {
  pill.addEventListener("click", () => {
    categoryFilter.value = pill.dataset.category;

    document.querySelectorAll(".category-pill").forEach((item) => {
      item.classList.remove("active");
    });

    pill.classList.add("active");
    renderPets();
  });
});

// Feedback form browser validation.
const form = document.querySelector(".feedback-form");

if (form) {
  form.addEventListener("submit", (event) => {
    const error = document.querySelector("#form-error");

    if (!error) return;

    error.hidden = true;
    error.textContent = "";

    if (!form.checkValidity()) {
      event.preventDefault();
      error.textContent =
        "Please complete all required fields and enter a valid email address.";
      error.hidden = false;
      form.reportValidity();
    }
  });
}

const dateField = document.querySelector("#submitted-at");

if (dateField) {
  const localNow = new Date();
  localNow.setMinutes(
    localNow.getMinutes() - localNow.getTimezoneOffset()
  );
  dateField.value = localNow.toISOString().slice(0, 16);
}

const currentYear = document.querySelector("#current-year");

if (currentYear) {
  currentYear.textContent = new Date().getFullYear();
}

// Mobile navigation.
const menuToggle = document.querySelector(".menu-toggle");
const nav = document.querySelector("#primary-nav");

if (menuToggle && nav) {
  menuToggle.addEventListener("click", () => {
    const expanded =
      menuToggle.getAttribute("aria-expanded") === "true";

    menuToggle.setAttribute(
      "aria-expanded",
      String(!expanded)
    );

    nav.classList.toggle("open", !expanded);
  });

  nav.addEventListener("click", (event) => {
    if (event.target.matches("a")) {
      nav.classList.remove("open");
      menuToggle.setAttribute("aria-expanded", "false");
    }
  });
}

loadFavourites();