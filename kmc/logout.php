<?php
session_start();

// Unset the user_id from the session
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}

// Delete the user_id cookie by setting its expiration to a past time
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/'); // Set the path as per your application
}

// Redirect to the login page or home page after logout
header("Location: login.php");
exit();
?>
