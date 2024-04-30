<?php

session_start();

require_once 'dbConnect.php';
require_once 'Recipe.php';

// If user is not logged in, redirect to login page
if (!isset($_SESSION['validUser']) || !$_SESSION['validUser']) {
    header("Location: login.php");
    exit();
}

// Check if recipe form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitRecipe'])) {
    // retrieve form data for recipe submission
    $recipeName = $_POST['recipeName'];
    $servings = $_POST['servings'];
    $prepTime = $_POST['prepTime'];
    $cookTime = $_POST['cookTime'];
    $difficulty = $_POST['difficulty'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $sourceLink = $_POST['sourceLink'];

    // Handle image upload
    $recipeImage = $_FILES['recipeImage'];
    if ($recipeImage['error'] === UPLOAD_ERR_OK) {
        $recipeImageName = $recipeImage['name'];
        $recipeImageTemp = $recipeImage['tmp_name'];
        $targetDirectory = '../../images/';
        $targetFile = $targetDirectory . $recipeImageName;

        if (move_uploaded_file($recipeImageTemp, $targetFile)) {
            // Create a new Recipe object
            $recipe = new Recipe(null, $recipeName, $recipeImageName, $servings, $prepTime, $cookTime, $difficulty, $ingredients, $instructions, $sourceLink);

            // Prepare SQL statement to insert recipe into database
            $recipeStmt = $conn->prepare("INSERT INTO wdv341_recipes (recipeName, recipeImage, servings, prepTime, cookTime, difficulty, ingredients, instructions, sourceLink) VALUES (:recipeName, :recipeImage, :servings, :prepTime, :cookTime, :difficulty, :ingredients, :instructions, :sourceLink)");
            $recipeName = $recipe->getRecipeName();
            $recipeImage = $recipe->getRecipeImage();
            $servings = $recipe->getServings();
            $prepTime = $recipe->getPrepTime();
            $cookTime = $recipe->getCookTime();
            $difficulty = $recipe->getDifficulty();
            $ingredients = $recipe->getIngredients();
            $instructions = $recipe->getInstructions();
            $sourceLink = $recipe->getSourceLink();

            $recipeStmt->bindParam(':recipeName', $recipeName);
            $recipeStmt->bindParam(':recipeImage', $recipeImage);
            $recipeStmt->bindParam(':servings', $servings);
            $recipeStmt->bindParam(':prepTime', $prepTime);
            $recipeStmt->bindParam(':cookTime', $cookTime);
            $recipeStmt->bindParam(':difficulty', $difficulty);
            $recipeStmt->bindParam(':ingredients', $ingredients);
            $recipeStmt->bindParam(':instructions', $instructions);
            $recipeStmt->bindParam(':sourceLink', $sourceLink);

            if ($recipeStmt->execute()) {
                // Recipe inserted successfully
                echo '<script>alert("Recipe uploaded successfully!");</script>';
                // Delay the redirection for 3 seconds (adjust as needed)
                echo '<meta http-equiv="refresh" content="2;url=manageRecipes.php">';
                exit();
            } else {
                // Error with SQL execution
                $errorMessage = "Error uploading recipe.";
            }
        } else {
            // Failed to move uploaded file
            $errorMessage = "Failed to move uploaded file.";
        }
    } else {
        // Error uploading file
        $errorMessage = "Error uploading file: " . $recipeImage['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upload Recipe | Any-Plate</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../styles.css" />
    <link rel="stylesheet" href="../../fonts.css" />
    <!--Bootstrap 5.3.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        label {
            text-align: left;
        }



        #recipeInput {
            padding: 30px;
        }


        textarea.form-control,
        input.form-control,
        #recipeImage,
        #difficulty {
            width: 50%;
        }

        .linkButton {
            background-color: #00bf6380;

        }

        .linkButton:hover {
            background-color: #00BFA4;
        }

        .btn-secondary a {
            color: white;
        }

        footer {

            color: gray;
            padding: 20px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamically display the current year in footer
            const currentYear = new Date().getFullYear();
            document.querySelector("#currentYear").textContent = currentYear;

            // Toggle hamburger menu
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navContent = document.querySelector('.navbar-collapse');

            navbarToggler.addEventListener('click', function() {
                navContent.classList.toggle('show');
            });

            window.addEventListener('mouseup', function(e) {
                if (!navbarToggler.contains(e.target) && !navContent.contains(e.target)) {
                    navContent.classList.remove('show');
                }
            });
        });
    </script>

<body>

    <!--Navigation Menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded poppins-regular">
        <div class="container">
            <a class="navbar-brand" href="../index.html"><img src="../../images/logo.png" width="200px" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../about.html">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../contactPage/contact_form.php">Contact Us</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../registration/login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="py-3 mb-5 border-bottom">
        <div class="jumbotron text-center py-4">
            <h1 class="display-5 poppins-semibold">
                Savor Every Bite, Explore Every Recipe: <br />Any-Plate
            </h1>
            <p class="lead poppins-light">
                Your go-to destination for a world of delicious recipes
            </p>
        </div>
    </header>


    <main>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-12 bg-light border rounded-3">
                    <!-- Recipe Input Form -->

                    <div class="m-5 text-center">
                        <h4 class="mb-3">Upload Recipes</h4>
                        <p>All fields are required.</p>
                        <hr style="width: 50%; margin: auto;">
                    </div>

                    <form method="post" enctype="multipart/form-data" class="mb-4" id="recipeInput">
                        <div class="row mb-3 align-items-center">
                            <label for="recipeName" class="col-sm-4 col-form-label text-sm-end">Recipe Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="recipeName" name="recipeName" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="recipeImage" class="col-sm-4 col-form-label text-sm-end">Recipe Image</label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="recipeImage" name="recipeImage" accept="image/*" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="servings" class="col-sm-4 col-form-label text-sm-end">Servings</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="servings" name="servings" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="prepTime" class="col-sm-4 col-form-label text-sm-end">Preparation Time (mins)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="prepTime" name="prepTime" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="cookTime" class="col-sm-4 col-form-label text-sm-end">Cooking Time (mins)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="cookTime" name="cookTime" required />
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="difficulty" class="col-sm-4 col-form-label text-sm-end">Difficulty</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="difficulty" name="difficulty" required>
                                    <option value="" selected disabled>Select Difficulty</option>
                                    <option value="Easy">Easy</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Hard">Hard</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 align-items-center text-center">
                            <label for="ingredients" class="form-label">Ingredients (One ingredient per line)</label>
                            <textarea class="form-control mx-auto" id="ingredients" name="ingredients" rows="5" required></textarea>
                        </div>
                        <div class="mb-3 align-items-center text-center">
                            <label for="instructions" class="form-label">Instructions (One step per line)</label>
                            <textarea class="form-control mx-auto" id="instructions" name="instructions" rows="5" required></textarea>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="sourceLink" class="col-sm-4 col-form-label text-sm-end">Source Link:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="sourceLink" name="sourceLink" required />
                            </div>
                        </div>
                        <div class="text-center py-5">
                            <button type="submit" class="btn border border-secondary linkButton" name="submitRecipe">Submit</button>
                            <br>
                            <br>
                            <button type="link" class="btn link btn-secondary" name="returnButton">
                                <a href="../registration/login.php" name="returnDashboard">Return to Dashboard</a></button>
                        </div>

                        <!--Honeypot-->
                        <div style="display: none;">
                            <label for="honeypot">Are you a bot?</label>
                            <input type="text" id="honeypot" name="honeypot">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-light text-center border-top mt-5">
        <p>&copy; <span id="currentYear"></span> Any-Plate</p>
    </footer>
</body>

</html>