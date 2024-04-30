<?php

require_once 'dbConnect.php';
require_once 'Recipe.php';

// Confirmation message prior to leaving the page
function confirmLeave()
{
    return 'Heads up! You have unsaved changes. Are you sure you want to leave this page?';
}

// Check if the recipe ID is in the URL
if (isset($_GET['id'])) {
    $recipeId = $_GET['id'];



    // Fetch the recipe data from the DB
    $stmt = $conn->prepare("SELECT * FROM wdv341_recipes WHERE id = :recipeId");
    $stmt->bindParam(':recipeId', $recipeId);
    $stmt->execute();
    $recipeData = $stmt->fetch(PDO::FETCH_ASSOC);


    // Check if the recipe exists
    if ($recipeData) {
        $newImagePath = $recipeData['recipeImage'];

        // If there is recipe data submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            var_dump($_POST);

            // Process form data
            // Validate & update DB
            // Redirect or display success msg

            // Check if a new image file is uploaded
            if (!empty($_FILES['recipeImage']['name'])) {
                var_dump($_FILES);

                // Check for upload errors
                if ($_FILES['recipeImage']['error'] !== UPLOAD_ERR_OK) {
                    echo "Error uploading image: " . $_FILES['recipeImage']['error'];
                    exit();
                }

                // Validate the uploaded file
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $uploadedFileName = $_FILES['recipeImage']['name'];
                $uploadedFileExtension = strtolower(pathinfo($uploadedFileName, PATHINFO_EXTENSION));

                if (!in_array($uploadedFileExtension, $allowedExtensions)) {
                    echo "Error: Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
                    exit();
                }

                // Generate a unique filename
                $newImagePath = uniqid('recipe_image_') . '.' . $uploadedFileExtension;

                // Move uploaded img to the target directory
                $targetDirectory = '../../images/';
                $targetFile = $targetDirectory . $newImagePath;

                // Check if the target dir exists and is writable to allow img upload
                if (!is_dir($targetDirectory) || !is_writable($targetDirectory)) {
                    echo "Error: Target directory is not writable or does not exist.";
                    exit();
                }

                if (!move_uploaded_file($_FILES["recipeImage"]["tmp_name"], $targetFile)) {
                    echo "Error uploading image.";
                    exit();
                }
            }

            // Update recipe data in the db
            $stmt = $conn->prepare("UPDATE wdv341_recipes SET 
    recipeName = :recipeName, 
    recipeImage = :recipeImage,
    servings = :servings, 
    prepTime = :prepTime, 
    cookTime = :cookTime, 
    difficulty = :difficulty, 
    ingredients = :ingredients, 
    instructions = :instructions, 
    sourceLink = :sourceLink 
    WHERE id = :recipeId");

            // Bind parameters
            $stmt->bindParam(':recipeId', $_POST['recipeId']);
            $stmt->bindParam(':recipeName', $_POST['recipeName']);
            $stmt->bindParam(':recipeImage', $newImagePath);
            $stmt->bindParam(':servings', $_POST['servings']);
            $stmt->bindParam(':prepTime', $_POST['prepTime']);
            $stmt->bindParam(':cookTime', $_POST['cookTime']);
            $stmt->bindParam(':difficulty', $_POST['difficulty']);
            $stmt->bindParam(':ingredients', $_POST['ingredients']);
            $stmt->bindParam(':instructions', $_POST['instructions']);
            $stmt->bindParam(':sourceLink', $_POST['sourceLink']);

            // Execute the statement
            if ($stmt->execute()) {
                // Display success message
                echo "<script>
                setTimeout(function() {
                alert('Recipe updated successfully');
                window.location.href = 'manageRecipes.php';
                }, 300); 
                </script>";
                // Prevent immediate redirection
                exit();
            } else {
                // Handle database update errors
                echo "Error updating recipe.";
                exit();
            }
        }
    } else {
        // Recipe not found
        echo "<h1>Recipe not found!</h1>";
    }
} else {
    // Redirect to error page if recipe ID is not provided in the URL
    header("Location: error.php");
    exit();
}
?>
<!-- Metadata -->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Update Recipes | Any-Plate</title>
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
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .edit-input {
        border: 1px solid #ddd;
        padding: 5px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;

    }

    .centerTextarea {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .linkButton {
        background-color: #00bf6380;

    }

    .linkButton:hover {
        background-color: #00BFA4;
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

    function previewImage(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let output = document.querySelector('#preview');
            output.src = reader.result;
            output.style.display = 'block';
            document.querySelector('#originalImage').style.display = 'none';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // Show footer when at bottom of page
    window.addEventListener("scroll", function() {
        let footer = document.querySelector("#footer");
        let scrollPosition = window.scrollY;
        let windowHeight = window.innerHeight;
        let documentHeight = document.body.clientHeight;

        // When to display footer based on how close user is to bottom of page
        let threshold = 100;

        // Calculate the position where the footer should be displayed
        let footerPosition = documentHeight - windowHeight - threshold;

        // Show or hide the footer based on scroll position
        if (scrollPosition >= footerPosition) {
            footer.style.display = "block";
        } else {
            footer.style.display = "none";
        }
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

    <header class="py-3 mb-5 border-bottom">
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
        <!-- Recipe Details Section -->
        <div class="container mt-1">
            <div class="row justify-content-center">
                <h2 class="m-5 text-center poppins-medium">Update Recipe</h2>
                <div class="col-lg-8">
                    <div class="recipeBlock bg-light border p-4">

                        <!--Display original recipe image-->
                        <img id="originalImage" src="<?php echo '../../images/' . $recipeData['recipeImage']; ?>" alt="<?php echo $recipeData['recipeName']; ?>" class="recipe-image img-fluid rounded m-4" style="max-width: 300px;">

                        <!--preview img (hidden by default) -->
                        <img id="preview" class="recipe-image img-fluid rounded" src="#" alt="Preview" style="max-width: 300px; display: none;">

                        <!--Input Form-->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $recipeId; ?>" method="POST" enctype="multipart/form-data">
                            <!-- Honeypot field -->
                            <div style="position: absolute; left: -5000px;" aria-hidden="true">
                                <input type="text" name="honeypot" tabindex="-1">
                            </div>

                            <!--Hidden field to store recipe ID in order to display selected recipe-->
                            <input type="hidden" name="recipeId" value="<?php echo $recipeData['id']; ?>">

                            <!--file input for new recipe image -->
                            <label for="recipeImage">Recipe Image:</label>
                            <input type="file" id="recipeImage" name="recipeImage" class="edit-input" onchange="previewImage(event)">

                            <!-- Recipe name input-->
                            <label for="recipeName">Recipe Name:</label>
                            <input type="text" id="recipeName" name="recipeName" class="edit-input" value="<?php echo $recipeData['recipeName']; ?>">

                            <!--Servings input-->
                            <label for="servings">Servings:</label>
                            <input type="number" id="servings" name="servings" class="edit-input" value="<?php echo $recipeData['servings'] ?>">

                            <!--Preparation time input-->
                            <label for="prepTime">Preparation Time (mins):</label>
                            <input type="number" id="prepTime" name="prepTime" class="edit-input" value="<?php echo $recipeData['prepTime'] ?>">

                            <!-- Cook time input-->
                            <label for="cookTime">Cook Time (mins):</label>
                            <input type="number" id="cookTime" name="cookTime" class="edit-input" value="<?php echo $recipeData['cookTime'] ?>">

                            <!--Difficulty input-->
                            <label for="difficulty">Difficulty:</label>
                            <select id="difficulty" name="difficulty" class="edit-input">
                                <option value="Easy" <?php if ($recipeData['difficulty'] == 'Easy') echo 'selected'; ?>>Easy</option>
                                <option value="Medium" <?php if ($recipeData['difficulty'] == 'Medium') echo 'selected'; ?>>Medium</option>
                                <option value="Hard" <?php if ($recipeData['difficulty'] == 'Hard') echo 'selected'; ?>>Hard</option>
                            </select>

                            <!--Ingredients input-->
                            <label for="ingredients">Ingredients:</label>
                            <div class="centerTextarea"> <textarea id="ingredients" name="ingredients" class="edit-input" style="height: 300px;"><?php echo $recipeData['ingredients']; ?></textarea></div>

                            <!--Instructions input-->
                            <label for="instructions">Instructions:</label>
                            <div class="centerTextarea"> <textarea id="instructions" name="instructions" class="edit-input" style="height: 300px;"><?php echo $recipeData['instructions']; ?></textarea></div>

                            <!--Source Link input-->
                            <label for="sourceLink">Source Link:</label>
                            <input type="text" id="sourceLink" name="sourceLink" class="edit-input" value="<?php echo $recipeData['sourceLink'] ?>">


                            <!-- Save and cancel buttons -->
                            <div class="buttons mt-2">
                                <button type="submit" name="submit" class="btn border border-secondary linkButton">Save</button>
                                <a href="manageRecipes.php" class="btn btn-sm btn-secondary p-2" onclick="return confirm('<?php echo confirmLeave(); ?>')">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-light text-center border-top" style="display: none" id="footer">
        <p>&copy; <span id="currentYear"></span> Any-Plate</p>
    </footer>



    <!--Bootstrap JavaScript libraries-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>