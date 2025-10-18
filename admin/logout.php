<?php
/**
 * E-License System | Logout
 *
 * This script securely destroys the user's session
 * and redirects them to the login page.
 */

// Always start the session to access it.
session_start();

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Set a success message for the login page
session_start();
$_SESSION['success_message'] = "You have been logged out successfully.";

// Redirect to the login page
header("Location: ../index.php");
exit();
?>
