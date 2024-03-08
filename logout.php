<?php
    // Start the session
    session_start();

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page with a query parameter
    header("location: login.php?logout=1"); // This adds "?logout=1" to the URL to indicate that the user logged out
    exit;
?>
