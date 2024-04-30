<?php

session_start();

require_once 'dbConnect.php';
require_once 'Auth.php';

$auth = new Auth($conn);  // Instantiate Auth class with the database connection, using private $conn property that holds DB connection object

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Retrieve username & password from the login form
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  if ($auth->login($username, $password)) {
    $successMessage = "Login successful. Welcome, Administrator!";
  } else {
    $errorMessage = "Invalid username or password. Please try again.";
  }
}
//end of login form


// Check if recipe form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitRecipe'])) {

  // Handle image upload
  $recipeImage = $_FILES['recipeImage']['name'];
  $recipeImageTemp = $_FILES['recipeImage']['tmp_name'];
  move_uploaded_file($recipeImageTemp, '../images/' . $recipeImage);

  // Retrieve form data for recipe submission
  $recipeName = $_POST['recipeName'];
  $servings = $_POST['servings'];
  $prepTime = $_POST['prepTime'];
  $cookTime = $_POST['cookTime'];
  $difficulty = $_POST['difficulty'];
  $ingredients = $_POST['ingredients'];
  $instructions = $_POST['instructions'];
  $sourceLink = $_POST['sourceLink'];

  // Prepare SQL statement to insert recipe into database
  $recipeStmt = $conn->prepare("INSERT INTO wdv341_recipes (recipeName, recipeImage, servings, prepTime, cookTime, difficulty, ingredients, instructions, sourceLink) VALUES (:recipeName, :recipeImage, :servings, :prepTime, :cookTime, :difficulty, :ingredients, :instructions, :sourceLink)");

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
    $successMessage = "Recipe uploaded successfully!";
  } else {
    // Error with SQL execution
    $errorMessage = "Error uploading recipe.";
  }
}

// Fetch recipes from DB
$sql = "SELECT * FROM wdv341_recipes";
$recipeStmt = $conn->prepare($sql);
$recipeStmt->execute();

$recipes = $recipeStmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Any-Plate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="styles.css" />


  <!--Bootstrap 5.3.3-->
  <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    .linkButton {
      background-color: #00bf6380;

    }

    .linkButton:hover {
      background-color: #00BFA4;
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
            <a class="nav-link" href="login.php">Login</a>
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
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-6 adminOptions">
          <div class="card bg-light">
            <div class="card-header text-center"> <!--add p-4 -->

              <!-- Auth user check -->
              <?php if (isset($_SESSION['validUser']) && $_SESSION['validUser']) : ?>

                <!-- Display welcome message if logged in -->
                <h3 class="mb-0">Welcome, Administrator!</h3>
            </div>
            <div class="card-body text-center m-3">
              <h5 class="card-title mb-4">What would you like to do?</h5>
              <div>
                <a href="../recipeManager/uploadRecipe.php" class="btn border border-secondary linkButton">Upload Recipes</a>
                <a href="../recipeManager/manageRecipes.php" class="btn border border-secondary linkButton">Manage Recipes</a>
              </div>
            </div>

            <!-- Logout form -->
            <div class=" card-footer text-muted text-center p-3">
              <form method="post" action="logout.php">
                <button type="submit" class="btn btn-secondary">Logout</button>
              </form>
            </div>
          </div>
        <?php else : ?>
          <!-- Display login form if not logged in -->
          <h2 class="card-title text-center m-3">Administrator Login</h2>
          <?php if (isset($errorMessage)) : ?>
            <p class="card-text text-center" style="color: red;"><?php echo $errorMessage; ?></p>
          <?php endif; ?>

          <!-- Login Form -->
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="container m-3">
              <div class="row justify-content-center">
                <div class="col-lg-6">
                  <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn border border-secondary linkButton">Login</button>
                  </div>
                </div>
              </div>
            </div>

          </form>
        <?php endif; ?>
        </div>
      </div>

    </div>
    </div>
    </div>
  </main>

  <footer class=" bg-light text-center border-top mt-5">
    <p>&copy; <span id="currentYear"></span> Any-Plate</p>
  </footer>

  <!--Bootstrap JavaScript libraries-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>