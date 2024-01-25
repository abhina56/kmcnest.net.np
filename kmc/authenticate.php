<?php
session_start();
include '../config.php'; // Include your database connection script

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($username && $password) {
    // Prepare statement to avoid SQL Injection
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) { // Check if the plain text password matches
            // Password is correct, start a new session
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: index.php"); // Redirect to a logged-in page
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
} else {
    echo "Username and password are required.";
}

$conn->close();
?>
