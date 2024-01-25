<?php

// Replace these values with your actual database credentials
$servername = "localhost";
$username = "kmc";
$password = "S@Skoi1998";
$dbname = "kmcnestn_kmc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
