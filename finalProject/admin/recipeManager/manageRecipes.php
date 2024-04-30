<?php
session_start();

// User authentication check - if not auth, return to login
if (!isset($_SESSION['validUser']) || !$_SESSION['validUser']) {
    header("Location: login.php");
    exit();
}

require_once 'dbConnect.php';

// Fetch $recipes from DB
require_once 'fetchRecipes.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Recipes | Any-Plate</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- Font Families -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
    <!-- Custom Stylesheets -->
    <link rel="stylesheet" href="../../styles.css" />
    <link rel="stylesheet" href="../../fonts.css" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <style>
        .recipeBlock {
            border: 1px solid #dddddd;
            padding: 100px;
            margin-bottom: 10px;

        }

        .verticalScroll {
            overflow-y: auto;
            height: 1300px;
            overflow-y: scroll;
        }

        .link {
            background-color: #00bf6380;
            margin-bottom: 30px;
        }

        .link:hover {
            background-color: #00bfa4;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamically display the current year in footer
            const currentYear = new Date().getFullYear();
            document.querySelector("#currentYear").textContent = currentYear;

            function confirmDelete() {
                return confirm("Are you sure you want to delete this recipe?");
            }

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
</head>


<body>
    <!--Navigation Menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded poppins-regular">
        <div class="container">
            <a class="navbar-brand" href="../../index.html"><img src="../../images/logo.png" width="200px" /></a>
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

    <header class="py-3 border-bottom">
        <div class="jumbotron text-center py-4">
            <h1 class="display-5 poppins-regular">
                Savor Every Bite, Explore Every Recipe: <br />Any-Plate
            </h1>
            <p class="lead poppins-light">
                Your go-to destination for a world of delicious recipes
            </p>
        </div>
    </header>

    <main>
        <!-- Recipe Blocks -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <h2 class="m-5 text-center poppins-medium">Manage Recipes</h2>
                <div class="col-lg-12 verticalScroll">
                    <?php
                    $counter = 0;
                    ?>
                    <!--loop through recipes and display each in a block -->
                    <?php
                    //var_dump($recipes);
                    foreach ($recipes as $recipe) : ?>
                        <!--Increment the counter on each iteration-->
                        <?php $counter++; ?>
                        <div class="recipeBlock bg-light">
                            <h3 class="mb-3"><?php echo $recipe->getRecipeName(); ?></h3>
                            <img src="<?php echo '../../images/' . $recipe->getRecipeImage(); ?>" alt="<?php echo $recipe->getRecipeName(); ?>" style="max-width: 200px;" class="img-fluid rounded m-3">
                            <p><strong>Servings:</strong> <?php echo $recipe->getServings(); ?></p>
                            <p><strong>Prep Time (mins):</strong> <?php echo $recipe->getPrepTime(); ?></p>
                            <p><strong>Cook Time (mins):</strong> <?php echo $recipe->getCookTime(); ?></p>
                            <p><strong>Difficulty:</strong> <?php echo $recipe->getDifficulty(); ?></p>
                            <h4>Ingredients:</h4>
                            <ul>
                                <?php
                                $ingredients = explode("\n", $recipe->getIngredients());
                                foreach ($ingredients as $ingredient) {
                                    if (!empty(trim($ingredient))) {
                                        echo '<li>' . $ingredient . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                            <h4>Instructions:</h4>
                            <ol>
                                <?php
                                $instructions = explode("\n", $recipe->getInstructions());
                                foreach ($instructions as $instruction) {
                                    if (!empty(trim($instruction))) {
                                        echo '<li>' . $instruction . '</li>';
                                    }
                                }
                                ?>
                            </ol>
                            <p><strong>Source Link:</strong> <?php echo $recipe->getSourceLink(); ?></p>
                            <a href="updateRecipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="btn btn-sm btn-primary">Update</a>
                            <a href="deleteRecipe.php?id=<?php echo $recipe->getRecipeId(); ?>" class="btn btn-sm btn-danger delete-btn" onclick="return confirmDelete();">Delete</a>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="text-center">
                <button type="link" class="btn link m-3"><a href="../registration/login.php">Return to Dashboard</a></button>
            </div>
        </div>

    </main>

    <footer class="bg-light text-center border-top mt-5">
        <p>&copy; <span id="currentYear"></span> Any-Plate</p>
    </footer>



    <!--Bootstrap JavaScript libraries-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>