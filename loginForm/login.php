<?php
session_start();

// Include database connection
require_once 'dbConnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Retrieve username & password from the login form
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';

  // Prepare a SELECT query to retrieve user record based on username input provided
  $stmt = $conn->prepare("SELECT * FROM wdv341_users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch();

  // Verify user's credentials 
  if ($user) {
    // Retrieve hashed password from database based on username
    $storedPassword = $user['password_hash']; // fetch from database

    // Verify the password input against the hashed password
    if (password_verify($password, $storedPassword)) {
      // Password is correct
      // Start a session and store the user's data
      $_SESSION['username'] = $user['username'];
      $_SESSION['validUser'] = true; // Set session variable
      $successMessage = "Login successful. Welcome, Administrator!";
    } else {
      $errorMessage = "Invalid username or password. Please try again.";
    }
  } else {
    $errorMessage = "Invalid username or password. Please try again.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Administrator Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PqpFzOuF2acfGMbeWfztz3MmXH6t6Iv0qFSsB/U07N4yV/K1fz6f+BzwnqVvWmZ+" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <h2>Administrator Login</h2>
    <?php if (isset($_SESSION['validUser']) && $_SESSION['validUser']) : ?>

      <!-- Display admin options -->

      <h3>Welcome, Administrator!</h3>

      <!-- Add New Event Form -->
      <?php require_once 'inputEventWithValidation.php'; ?>

      <!-- Show list of events -->
      <?php require_once 'selectEvents.php'; ?>

      <!--Logout-->
      <p>
      <form method="post" action="logout.php">
        <button type="submit">Logout</button>
      </form>
      </p>

    <?php else : ?>

      <!-- Display login form if not signed in -->
      <?php if (isset($errorMessage)) : ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
      <?php endif; ?>

      <form method="post">
        <div>
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Login</button>
      </form>

    <?php endif; ?>
    <?php if (isset($successMessage)) : ?>
      <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

  </div>
</body>

</html>