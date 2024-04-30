// Function to toggle visibility of ingredients or instructions
function toggleVisibility(listId) {
  let list = document.getElementById(listId);
  list.classList.toggle("hidden");
}

// Event listener for toggle buttons
let toggleButtons = document.querySelectorAll(".toggle-button");
toggleButtons.forEach(function (button) {
  button.addEventListener("click", function () {
    let listId = this.getAttribute("data-list");
    toggleVisibility(listId);
  });
});

// Function to change servings
function changeServings(option) {
  // Retrieve the default serving size from the page
  let defaultServings = parseFloat(
    document.querySelector("#servingsValue").textContent
  );

  // to make sure servingsValue always has a default value
  if (isNaN(defaultServings)) {
    // If the default serving size is not a valid number, set it to 1 as a fallback
    defaultServings = 1;
    document.querySelector("#servingsValue").textContent =
      defaultServings.toFixed(2);
  }

  let factor = 1;

  switch (option) {
    case "half":
      factor = 0.5;
      break;
    case "double":
      factor = 2;
      break;
    default:
      factor = 1;
  }

  // Adjust ingredient quantities
  const ingredientList = document.querySelector("#ingredientList");
  const ingredients = ingredientList.querySelectorAll("li");
  ingredients.forEach((ingredient) => {
    let text = ingredient.textContent.trim();
    const firstSpaceIndex = text.indexOf(" ");
    let quantity = parseFloat(text.slice(0, firstSpaceIndex));
    let parts = text.slice(firstSpaceIndex + 1).split(" ");

    // Handle fractional symbols like ½ or ¾
    parts = parts.map((part) => {
      if (part.match(/^\d\/\d$/)) {
        const [numerator, denominator] = part.split("/");
        return parseFloat(numerator) / parseFloat(denominator);
      } else {
        return part;
      }
    });

    // Handle ingredient ranges if entered like "1-2"
    if (!isNaN(quantity) && !isNaN(factor)) {
      if (quantity.toString().includes("-")) {
        const range = quantity.toString().split("-");
        quantity = (parseFloat(range[0]) + parseFloat(range[1])) / 2;
      }

      // Update quantity based on factor
      quantity *= factor;

      // Makre sure that quantity is rounded to two decimal places
      ingredient.textContent = quantity.toFixed(2) + " " + parts.join(" ");
    }
  });

  // Update servings display
  document.querySelector("#servingsValue").textContent = (
    defaultServings * factor
  ).toFixed(2);
}

document.addEventListener("DOMContentLoaded", function () {
  // Dynamically display the current year in footer
  const currentYear = new Date().getFullYear();
  document.querySelector("#currentYear").textContent = currentYear;

  // Toggle hamburger menu
  const navbarToggler = document.querySelector(".navbar-toggler");
  const navContent = document.querySelector(".navbar-collapse");

  navbarToggler.addEventListener("click", function () {
    navContent.classList.toggle("show");
  });

  window.addEventListener("mouseup", function (e) {
    if (!navbarToggler.contains(e.target) && !navContent.contains(e.target)) {
      navContent.classList.remove("show");
    }
  });

  // Fetch recipes and display them
  fetchRecipes();

  // Add click event listener to the parent element of carousel images
  const carouselInner = document.querySelector(".carousel-inner");
  carouselInner.addEventListener("click", function (event) {
    // Check if the clicked element is an image within a carousel item
    if (
      event.target.tagName === "IMG" &&
      event.target.closest(".carousel-item")
    ) {
      // Get the index of the clicked image
      const index = Array.from(carouselInner.children).indexOf(
        event.target.closest(".carousel-item")
      );
      // Call the function to display recipe from the clicked image
      displayRecipeFromImage(index);
    }
  });

  function displayRecipeFromImage(index) {
    // Retrieve the list of recipes
    const recipes = Array.from(document.querySelectorAll(".recipe-item"));
    // Check if the index is within the bounds of the recipes array
    if (index >= 0 && index < recipes.length) {
      // Get the recipe associated with the clicked image
      const recipeData = JSON.parse(recipes[index].getAttribute("data-recipe"));
      // Display the recipe details
      displayRecipeDetails(recipeData);
    }
  }

  function fetchRecipes() {
    // Make an AJAX call to fetch recipes
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Check if the response is valid JSON
          try {
            const recipes = JSON.parse(xhr.responseText);
            displayRecipes(recipes);
          } catch (error) {
            console.error("Error parsing JSON:", error);
            //error to user here
          }
        } else {
          // Error handling for non-200 status codes
          console.error("Error fetching recipes:", xhr.status);
          // Error to user here
        }
      }
    };
    xhr.onerror = function () {
      // Error handling for network errors
      console.error("Network error occurred while fetching recipes.");
      // error to user here
    };
    xhr.open("GET", "fetchRecipesForIndex.php");
    xhr.send();
  }

  function displayRecipes(recipes) {
    const recipesList = document.querySelector("#recipes");
    const carouselInner = document.querySelector(".carousel-inner");

    recipes.forEach((recipe, index) => {
      const listItem = document.createElement("li");
      listItem.textContent = recipe.recipeName;
      listItem.classList.add("recipe-item");
      // Store recipe data as a data attribute
      listItem.setAttribute("data-recipe", JSON.stringify(recipe));
      listItem.addEventListener("click", function () {
        displayRecipeDetails(recipe);
      });
      recipesList.appendChild(listItem);

      // Add a carousel item for each recipe image
      const carouselItem = document.createElement("div");
      carouselItem.classList.add("carousel-item");
      carouselItem.setAttribute("data-recipe-id", index + 1);

      const image = document.createElement("img");
      image.src = "images/" + recipe.recipeImage;
      image.classList.add("d-block");
      image.alt = recipe.recipeName;

      carouselItem.appendChild(image);
      carouselInner.appendChild(carouselItem);
    });

    // Activate the first carousel item
    const firstCarouselItem = carouselInner.querySelector(".carousel-item");
    firstCarouselItem.classList.add("active");
  }

  function displayRecipeDetails(recipe) {
    console.log("Recipe data:", recipe);

    // Hide the placeholder image
    document.querySelector("#mainImage").style.display = "none";

    // Show the recipe details container
    const recipeDetails = document.querySelector("#recipeDetails");

    if (recipeDetails) {
      recipeDetails.style.display = "block";

      // Display the recipe details
      document.querySelector("#recipeName").textContent = recipe.recipeName;
      document
        .querySelector("#recipeImage")
        .setAttribute("src", "images/" + recipe.recipeImage);
      document.querySelector("#servingsValue").textContent = recipe.servings;
      document.querySelector("#prepTimeValue").textContent = recipe.prepTime;
      document.querySelector("#cookTimeValue").textContent = recipe.cookTime;
      document.querySelector("#difficultyValue").textContent =
        recipe.difficulty;

      // Display ingredients as list items
      const ingredientList = document.querySelector("#ingredientList");
      if (ingredientList) {
        ingredientList.innerHTML = "";
        if (recipe.ingredients) {
          const ingredientsArray = recipe.ingredients.split("\n"); // Split by newline
          ingredientsArray.forEach((ingredient) => {
            const trimmedIngredient = ingredient.trim();
            if (trimmedIngredient) {
              // Check if ingredient is not empty after trimming
              const li = document.createElement("li");
              li.textContent = trimmedIngredient;
              ingredientList.appendChild(li);
            }
          });
        } else {
          // Handle case where ingredients are not available
          const li = document.createElement("li");
          li.textContent = "Ingredients not available";
          ingredientList.appendChild(li);
        }
      }

      // Display instructions as list items
      const instructionList = document.querySelector("#instructionList");
      if (instructionList) {
        instructionList.innerHTML = "";
        if (recipe.instructions) {
          const instructionsArray = recipe.instructions.split("\n"); // next line
          instructionsArray.forEach((instruction) => {
            const trimmedInstruction = instruction.trim();
            if (trimmedInstruction) {
              // Check if instruction is not empty after trimming
              const li = document.createElement("li");
              li.textContent = trimmedInstruction;
              instructionList.appendChild(li);
            }
          });
        } else {
          // Handle case where instructions are not available
          const li = document.createElement("li");
          li.textContent = "Instructions not available";
          instructionList.appendChild(li);
        }
      }
    }
  }
});
