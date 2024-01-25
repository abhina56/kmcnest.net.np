<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/f1e6b711f2.js" crossorigin="anonymous"></script>
    <title>काठमाडौँ महानगरपालिका - निशुल्क उपचार सहजिकरण सेवा</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        :root {
            --primary-color: #3498db; /* Blue */
            --secondary-color: #e74c3c; /* Red */
            --accent-color: #f1c40f; /* Yellow */
            --background-color: #ecf0f1; /* Light Gray */
            --text-color: #2c3e50; /* Dark Blue */
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .navbar-custom {
            background-color: #007bff; /* Blue theme */
            color: white;
        }

        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }

        .navbar-custom .nav-link:hover {
            color: #aaa;
        }

        #content {
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Header */
        header {
            background: var(--primary-color);
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png');
            color: black;
            padding: 20px 0;
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
        }

        .header-title h1 {
            text-align: center;
        }

        nav {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 10px 0;
        }

        nav ul {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 0;
            list-style: none;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 4px;
            transition: transform 0.3s ease, background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: var(--accent-color);
            transform: translateY(-5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                text-align: center;
            }

            .logo-container {
                margin-bottom: 10px;
            }

            .header-title {
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                height: 100%;
            }

            .header-title h1, .header-title h2 {
                font-size: smaller;
                margin-top: 0;
            }

            .form-control {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="cropped-logo.png" alt="Logo" width="150px" height="150px">
        </div>
        <div class="header-title">
            <h1>काठमाडौँ महानगरपालिका</h1>
            <h2>निशुल्क उपचार सहजिकरण सेवा</h2>
        </div>
        <div class="logo-container">
            <img src="kmc-logo.png" alt="KMC Logo" width="150px" height="150px">
        </div>
    </div>
</header>

<!-- Navigation -->
<nav class="navbar-custom">
    <ul>
        <li><a href="hospital.php">Home</a></li>
        <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="files.php"><i class="fas fa-download"></i> Download</a></li>
            <?php
            if (isset($_SESSION['hospital_id'])) {
                echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
            } else {
                echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
            }
            ?>
    </ul>
</nav>
    <?php

if (isset($_COOKIE['hospital_id'])) {
    $hospital_id = $_COOKIE['hospital_id'];
    // You can now use $hospital_id in your script
} else {
    // Cookie 'hospital_id' is not set
    // Handle this case appropriately
    $hospital_id = $_SESSION['hospital_id'];

}
?>

<?php
include 'config.php'; // Database connection

    $hospital_id = $_SESSION['hospital_id'];
if (isset($_GET['hospital_id'])) {
    $hospital_id = $conn->real_escape_string($_GET['hospital_id']);
}

// Initialize variables to store hospital data
$hospital_name = $total_bed = $hospital_type = $contact_person = $contact_email = $contact_number = $address = '';

// Fetch existing data from the database
$dataFound = false;
if ($hospital_id != '') {
    $sql = "SELECT * FROM hospital WHERE hospital_id = '$hospital_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hospital_name = $row['hospital_name'];
        $total_bed = $row['total_bed'];
        $hospital_type = $row['hospital_type'];
        $contact_person = $row['contact_person'];
        $contact_email = $row['contact_email'];
        $contact_number = $row['contact_number'];
        $address = $row['address'];
        $hashedPassword = $row['hashedPassword'];
        $dataFound = true;
    }
}

if (!$dataFound) {
    echo 'No Data found';
}
?>

    <div class="container mt-5">
        <h2>Hospital Information Form</h2>
        <br>
        <form method="post" action="profile_update.php">
            <!-- Hospital Name -->
            <div class="form-group">
                <label for="hospital_name">Hospital Name:</label>
<input type="text" class="form-control" name="hospital_name" value="<?php echo htmlspecialchars($hospital_name); ?>" required>
            </div>

            <!-- Total Beds -->
            <div class="form-group">
                <label for="total_bed">Total Beds:</label>
                <input type="number" class="form-control" id="total_bed" name="total_bed" value="<?php echo htmlspecialchars($row['total_bed']); ?>" required>
            </div>

            <!-- Hospital Type -->
            <div class="form-group">
                <label for="hospital_type">Hospital Type:</label>
                <select class="form-control" id="hospital_type" name="hospital_type">
                    <option value="Government">Government</option>
                    <option value="Private">Private</option>
                    <option value="Community">Community</option>
                    <option value="Cooperative">Cooperative</option>
                    <option value="Non-Government">Non-Government</option>
                </select>
            </div>

            <!-- Contact Person -->
            <div class="form-group">
                <label for="contact_person">Contact Person:</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($row['contact_person']); ?>" required>
            </div>

            <!-- Contact Email -->
            <div class="form-group">
                <label for="contact_email">Contact Email:</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($row['contact_email']); ?>" required>
            </div>

            <!-- Contact Number -->
            <div class="form-group">
                <label for="contact_number">Contact Number:</label>
                <input type="tel" class="form-control" id="contact_number" name="contact_number" pattern="[0-9]{10}" value="<?php echo htmlspecialchars($row['contact_number']); ?>" required>
            </div>

            <!-- Address -->
            <!-- Address -->
<div class="form-group">
    <label for="address">Address:</label>
    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($row['address']); ?></textarea>
</div>

                <input type="hidden" name="hospital_id" value="<?php echo htmlspecialchars($hospital_id); ?>">

            <!-- Hashed Password (usually not editable, but included as per request) -->
            <div class="form-group">
                <label for="hashedPassword">Password (Hashed):</label>
                <input type="password" class="form-control" id="hashedPassword"  name="hashedPassword" value="<?php echo htmlspecialchars($row['hashedPassword']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
       <style>
                header {
            background: var(--primary-color);
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */
            color: black;
            padding: 20px 0;
            text-align: center;
            text-size: 2.3em;
line-height: 1.6;
            
        }
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
            
        }
        
   .header-title h1 {
            text-align: center;
            font-size: 2.3em;
            font-weight:600;
        }
        
        .header-title h2 {
            font-size: 1.8em;
            font-weight:600;
        }
        
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
}






@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        text-align: center;
    }
    
    .logo-container {
        margin-bottom: 10px;
    }
    
    .header-title {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    height: 100%;
}

.header-title h1, .header-title h2 {
    font-size: smaller;
    margin-top: 0; /* Adjust as needed */
}

    .form-control {
        width: 100%; /* Set to full width for small screens */
    }
}
    </style>
</body>
</html>
