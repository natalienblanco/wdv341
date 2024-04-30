<?php

require_once 'dbConnect.php';

class Auth
{
    private $conn;  //private property to hold database connection

    //constructor used to initialize the Auth object with a DB connection
    public function __construct(PDO $conn)
    {
        $this->conn = $conn;    // Assign the DB connection to the $conn prop
    }

    // Handle login method
    public function login($username, $password)
    {
        // Prepare SQL query to retrieve user info based on provided username
        $loginStmt = $this->conn->prepare("SELECT * FROM wdv341_users WHERE username = :username");
        $loginStmt->bindParam(':username', $username);  // Bind the username parameter to prepared statement
        $loginStmt->execute();

        $user = $loginStmt->fetch();    // Fetch user record from DB

        // Validate user's credentials
        if ($user && password_verify($password, $user['password_hash'])) {
            // If username & password match, set session variables to indiciate successful login
            $_SESSION['username'] = $user['username'];
            $_SESSION['validUser'] = true;
            return true;    // Return true to indicate successful login
        } else {
            return false;   // Or false to indicate failed login attempt
        }
    }

    // Handle user logout method
    public function logout()
    {
        // Unset all session variables and destroy the session
        session_unset();
        session_destroy();
    }

    // Other authentication methods can be added here as needed
}
