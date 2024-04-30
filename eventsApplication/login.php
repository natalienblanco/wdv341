<?php
session_start();

// Include database connection
require_once 'dbConnect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Retrieve username & password from the login form

  // Using Ternary Operator & Prepared Statement
  $username = isset($_POST['username']) ? $_POST['username'] : '';
  // Checks if 'username' key exists in the $_POST array
  // If it exists, assigns value to $username
  // if it was not submitted, assigns empty string to $username, 
  //preventing PHP notices & warnings


  $password = isset($_POST['password']) ? $_POST['password'] : '';
  // Checks if 'password' key exists
  // if it does, assigns value to $password
  // Otherwise, assigns empty string
  //preventing PHP notices & warnings

  // Prepare a SELECT query to retrieve user record based on username input provided
  $stmt = $conn->prepare("SELECT * FROM wdv341_users WHERE username = :username");
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch(); //assigns result of query to $user

  // Verify user's credentials 
  if ($user) { // If a user record was successfully retrieved from DB,
    // Retrieve hashed password from DB based on username
    $storedPassword = $user['password_hash'];

    // Verify the password input against the hashed password
    if (password_verify($password, $storedPassword)) {
      // Password is correct
      // Start a session and store the user's data
      $_SESSION['username'] = $user['username'];
      $_SESSION['validUser'] = true; // Set session variable to indicate user is logged in
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

  <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
  <div class="container">
    <h2>Login Page</h2>
    <?php
    // if a valid user, display admin dashboard
    if (isset($_SESSION['validUser']) && $_SESSION['validUser']) : ?>

      <h3>Welcome, Administrator!</h3>

      <!-- Display admin options -->

      <ol>

        <li><a href="inputEventWithValidation.php">Add New Event</a></li>

        <li><a href="selectEvents.php">View Events</a></li>

      </ol>

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