<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define an array to store error messages
    $errors = array();

    // Validate Hospital Name
    $hospital_name = trim($_POST["hospital_name"]);
    if (empty($hospital_name)) {
        $errors[] = "Hospital Name is required.";
    }

    // Validate Total Beds
    $total_bed = trim($_POST["total_bed"]);
    if (!is_numeric($total_bed) || $total_bed <= 0) {
        $errors[] = "Total Beds must be a positive number.";
    }

    // Validate Hospital Type
    $hospital_type = trim($_POST["hospital_type"]);
    if (empty($hospital_type)) {
        $errors[] = "Hospital Type is required.";
    }

    // Validate Contact Person
    $contact_person = trim($_POST["contact_person"]);
    if (empty($contact_person)) {
        $errors[] = "Contact Person is required.";
    }

    // Validate Contact Email
    $contact_email = trim($_POST["contact_email"]);
    if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Contact Email format.";
    }

  // Validate Contact Number
$contact_number = trim($_POST["contact_number"]);
if (!preg_match("/^\d{10}$/", $contact_number)) {
    $errors[] = "Contact Number must be a 10-digit number.";
}


    // Validate Address
    $address = trim($_POST["address"]);
    if (empty($address)) {
        $errors[] = "Address is required.";
    }

    // If there are no errors, process the form data
    if (empty($errors)) {
        // Process the form data and insert into the database
        // Include the database connection file
        include '../config.php';

        // Function to generate a random password
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

$password = generateRandomPassword(5);

// // Hash the password using password_hash
// $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$hashedPassword = $password;


        // Sanitize and get form data
        $hospital_name = mysqli_real_escape_string($conn, $hospital_name);
        $total_bed = mysqli_real_escape_string($conn, $total_bed);
        $hospital_type = mysqli_real_escape_string($conn, $hospital_type);
        $contact_person = mysqli_real_escape_string($conn, $contact_person);
        $contact_email = mysqli_real_escape_string($conn, $contact_email);
        $contact_number = mysqli_real_escape_string($conn, $contact_number);
        $address = mysqli_real_escape_string($conn, $address);
        $hashedPassword = mysqli_real_escape_string($conn, $hashedPassword);

        // Insert data into the hospital table
        $sql_insert = "INSERT INTO hospital (hospital_name, total_bed, hospital_type, contact_person, contact_email, contact_number, address, hashedPassword)
                       VALUES ('$hospital_name', '$total_bed', '$hospital_type', '$contact_person', '$contact_email', '$contact_number', '$address','$hashedPassword')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "Data inserted successfully";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
        header("Location: index.php");
        // Close the database connection
        $conn->close();

    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Dashboard and Data Entry</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Combined styles from both documents */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4; /* Adjusted to match the first document's style */
        }
        .navbar-custom {
            background-color: #007bff;
            color: white;
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }
        .navbar-custom .nav-link:hover {
            color: #aaa;
        }
        .header {
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png');
            background-size: cover;
            background-position: center;
            height: 200px;
            color: white;
            text-align: center;
        }
        /* Additional combined styles can be placed here */
    </style>
</head>
<body>
    <!-- Header with Image Background from the first document -->
    <div class="header">
        <h1>Your Hospital Name</h1>
        <p>Tagline or additional text</p>
    </div>
    
    <!-- Navbar from the first document -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="#">Hospital Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="bill_statistics.php"><i class="fas fa-chart-bar"></i> Bill Statistics</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="uploads.php"><i class="fas fa-upload"></i> Uploads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="monitor.php"><i class="fas fa-desktop"></i> Monitor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage.php"><i class="fas fa-cog"></i> Manage</a>
                </li>
                <li class="nav-item">
                    <!-- Toggle between Logout and Login based on session status -->
                    <?php session_start(); ?>
                    <?php if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])): ?>
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>

<div class="container">
    <h2>Hospital Data Entry Form</h2>

    <form method="post">
        <div class="form-group">
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" class="form-control" name="hospital_name" required>
        </div>

        <div class="form-group">
            <label for="total_bed">Total Beds:</label>
            <input type="number" class="form-control" name="total_bed" required>
        </div>

        <div class="form-group">
            <label for="hospital_type">Hospital Type:</label>
            <select name="hospital_type" class="form-control" id="hospital_type">
                <option value="Government">Government</option>
                <option value="Private">Private</option>
                <option value="Cummunity">Cummuinity</option>
                <option value="Co-Oprative">Co-Oprative</option>
                <option value="Non-Government">Non Government</option>

            </select>
        </div>

        <div class="form-group">
            <label for="contact_person">Contact Person:</label>
            <input type="text" class="form-control" name="contact_person" required>
        </div>

        <div class="form-group">
            <label for="contact_email">Contact Email:</label>
            <input type="email" class="form-control" name="contact_email" required>
        </div>

        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="phone" class="form-control" name="contact_number" required>
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" name="address" rows="4" required></textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="Submit">
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
