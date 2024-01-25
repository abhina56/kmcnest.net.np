<?php
    session_start();
?>
<?php

// Include the database connection file
include 'config.php';
// Retrieve hospital data from the database
$sql_select = "SELECT h.*, COUNT(p.p_id) AS active_patients, ROUND(0.1 * h.total_bed) AS allocated_beds
               FROM hospital h
               LEFT JOIN patient p ON h.hospital_id = p.hospital_id AND p.status = 'Active'
               GROUP BY h.hospital_id";
$result = $conn->query($sql_select);

// Retrieve the number of rows from the "hospital" table
$sql_count = "SELECT COUNT(*) AS row_count FROM hospital";
$result_count = $conn->query($sql_count);

// Check if the query was successful
if ($result_count) {
    // Fetch the row count value
    $row_count = $result_count->fetch_assoc()['row_count'];
} else {
    // Handle the error if the query fails
    $row_count = 0;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KMC Care</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">KMC Care</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hospital.php"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="files.php"><i class="fas fa-download"></i> Download</a>
                    </li>
                    <?php
                if (isset($_SESSION['hospital_id'])) {
                    // If hospital_id is set in the session, show Logout
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
                } else {
                    // If hospital_id is not set, show Login
                    echo '<li class="nav-item"><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>';
                }
                ?>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">
    <h2>View Hospitals</h2>
<br>
    <div class="table-container">
        <?php
        // PHP code to fetch data from the database
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <tr>
                        <th>Hospital ID</th>
                        <th>Hospital Name</th>
                        <th>Total Beds</th>
                        <th>Allocated Beds (10%)</th>
                        <th>Active Patients</th>
                        <th>Hospital Type</th>
                        <th>Contact Person</th>
                        <th>Contact Email</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row["hospital_id"]}</td>
                        <td>{$row["hospital_name"]}</td>
                        <td>{$row["total_bed"]}</td>
                        <td>{$row["allocated_beds"]}</td>
                        <td>{$row["active_patients"]}</td>
                        <td>{$row["hospital_type"]}</td>
                        <td>{$row["contact_person"]}</td>
                        <td>{$row["contact_email"]}</td>
                        <td>{$row["contact_number"]}</td>
                        <td>{$row["address"]}</td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No hospitals found in the database.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
    <div id="content" class="container">
        <!-- Placeholder for your page content -->
        <p>This is your main content area.</p>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
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

}
    </style>
</body>
</html>
