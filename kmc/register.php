<?php
include '../config.php'; // Include your database connection script

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$email = $_POST['email'] ?? ''; // Assuming you have an email field in your form

if ($username && $password && $email) {
    // Prepare statement to avoid SQL Injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email); // Storing password without hashing
    $result = $stmt->execute();

    if ($result) {
        echo "Registration successful. <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "All fields are required.";
}

$conn->close();
?>
