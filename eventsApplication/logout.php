<?php

session_start();

// Unset all session variables by assigning an empty array to the '$_SESSION' superglobal variable.
// Explicitly sets session variable to empty state
$_SESSION = array();


//session_unset(); could be used here as well by unsetting all of the variables that are registered in the current session,
// but not actually destroying the session itself.
// Instead it would remove tha values of the session variables, leaving the session ID (& any other session related info) intact.

// In the context of logging out a user & destroying the session completely, using '$_SESSION = array(); makes more sense
// as this ensures that all session variables cleared without leaving the state of the session data unclear.

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit;
