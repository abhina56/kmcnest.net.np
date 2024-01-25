<?php
// Start the session at the beginning of the script
session_start();

// Include the database connection file
include 'config.php';

// Check if the hospital_id is set in the session or cookies
$hospital_id = $_SESSION['hospital_id'] ?? $_COOKIE['hospital_id'] ?? null;

if ($hospital_id) {
    // Retrieve hospital data for the specific hospital ID
    $sql_select = "SELECT h.*, COUNT(p.p_id) AS active_patients, ROUND(0.1 * h.total_bed) AS allocated_beds
                   FROM hospital h
                   LEFT JOIN patient p ON h.hospital_id = p.hospital_id AND p.status = 'Admitted'
                   WHERE h.hospital_id = ?
                   GROUP BY h.hospital_id";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("i", $hospital_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    if ($result->num_rows > 0) {
        $hospital_data = $result->fetch_assoc();
    } else {
        echo "No data found for the hospital.";
    }

    $stmt->close();
} else {
    echo "Hospital ID not found in session or cookies.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>KMC Care</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
            font-weight:bold;
        }


        .table-custom {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table-custom th {
            background-color: #007bff;
            color: white;
        }
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
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
    </style>
    <style>



        .main {
            margin-top: 20px;
        }

        .table-custom {
            background-color: white;
            border-collapse: collapse;
            width: 100%;
        }

        .table-custom th, .table-custom td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-custom th {
            background-color: #007bff;
            color: white;
        }

        main{
            margin-left:10px;
            margin-right:10px;

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
<?php
// Include the database connection file
include 'config.php';
// Retrieve patient data from the database
$sql_select_patient = "SELECT * FROM patient";
$result_patient = $conn->query($sql_select_patient);
?>

<?php
$statusCounts = ['Death' => 0, 'Admitted' => 0, 'Discharged' => 0];

$sql_status_count = "SELECT status, COUNT(*) as count FROM patient WHERE hospital_id = $hospital_id GROUP BY status";
$result_status_count = $conn->query($sql_status_count);

if ($result_status_count) {
    while ($row = $result_status_count->fetch_assoc()) {
        $status = $row['status'];
        $count = $row['count'];
        if (array_key_exists($status, $statusCounts)) {
            $statusCounts[$status] = $count;
        }
    }
}
?>

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
<nav class="navbar-custom">
    <ul>
        <li><a href="#"> Home</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>
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
    <br>
    <br>
  <?php
    if ($hospital_id) {
    // SQL query to fetch the total number of beds from the specific hospital
    $sql_beds = "SELECT total_bed FROM hospital WHERE hospital_id = ?";
    $stmt_beds = $conn->prepare($sql_beds);
    $stmt_beds->bind_param("i", $hospital_id);
    $stmt_beds->execute();
    $result_beds = $stmt_beds->get_result();

    if ($result_beds->num_rows > 0) {
        $row_beds = $result_beds->fetch_assoc();
        $total_beds = $row_beds['total_bed'];
        $allocated_beds = round(0.1 * $total_beds); // Calculate 10% of total beds

        // SQL query to count the number of active patients
        $sql_patients = "SELECT COUNT(*) AS active_patients FROM patient WHERE hospital_id = ? AND status = 'Admitted'";
        $stmt_patients = $conn->prepare($sql_patients);
        $stmt_patients->bind_param("i", $hospital_id);
        $stmt_patients->execute();
        $result_patients = $stmt_patients->get_result();

        if ($result_patients->num_rows > 0) {
            $row_patients = $result_patients->fetch_assoc();
            $active_patients = $row_patients['active_patients'];

            // Displaying the results
            echo "<div class='container'>";
            echo "<h2>There are $active_patients patients in $allocated_beds allocated beds (10% of $total_beds total beds).</h2>";
            echo "</div>";
        }

        $stmt_patients->close();
    } else {
        echo "<div class='container'>";
        echo "<p>No data found for the specified hospital.</p>";
        echo "</div>";
    }

    $stmt_beds->close();
} else {
    echo "<div class='container'>";
    echo "<p>Hospital ID not found in session or cookies.</p>";
    echo "</div>";
}
?>
<a class='btn btn-primary' href="insert_p.php" style="margin-left:50%;">Add Patient</a>    
<div class="container">
    <h2 class="text-center mt-4">Patient Status Summary</h2>
    <table class="table table-bordered">
        <tr>
            <th>Status</th>
            <th>Count</th>
        </tr>
        <?php foreach ($statusCounts as $status => $count): ?>
            <tr>
                <td><?php echo htmlspecialchars($status); ?></td>
                <td><?php echo htmlspecialchars($count); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<br>
<br>
<main>

<div class="container">
    <h2 class="text-center mb-4">View Patients</h2>

    <?php
    // Include database configuration file
    include 'config.php';

    // Get the hospital ID from session or cookies
    $hospital_id = $_SESSION['hospital_id'] ?? $_COOKIE['hospital_id'] ?? null;

    if ($hospital_id) {
        // SQL query to fetch patients from the specific hospital
        $sql_select_patient = "SELECT * FROM patient WHERE hospital_id = ?";
        $stmt = $conn->prepare($sql_select_patient);
        $stmt->bind_param("i", $hospital_id);
        $stmt->execute();
        $result_patient = $stmt->get_result();

        // Check if there are patients in the database
        if ($result_patient->num_rows > 0) {
            // Output table header
            echo "<table class='table table-bordered table-striped' tag='table-two'>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Emergency Contact</th>
                        <th>Referred From</th>
                        <th>Hospital ID</th>
                        <th>Bed Number</th>
                        <th>Admission Date</th>
                        <th>Discharge/Transfer Date</th>
                        <th>Profile<th>
                        <th>Status</th>
                        <th>Outcome_Summary</th>
                    </tr>";

            // Output data of each row
            while ($row_patient = $result_patient->fetch_assoc()) {
                echo "<tr>
                        <td>{$row_patient["p_id"]}</td>
                        <td>{$row_patient["name"]}</td>
                        <td>{$row_patient["address"]}</td>
                        <td>{$row_patient["phone"]}</td>
                        <td>{$row_patient["emergency_contact"]}</td>
                        <td>{$row_patient["referred_from"]}</td>
                        <td>{$row_patient["hospital_id"]}</td>
                        <td>{$row_patient["bed_no"]}</td>
                        <td>{$row_patient["admission_date"]}</td>
                        <td>{$row_patient["discharge_transfer_date"]}</td>
                        <td><img src='{$row_patient['profile_picture_path']}' style='height: 100px; width: 100px;'></td>

                        <td>{$row_patient["status"]}</td>
                        <td><a class='btn btn-primary' href='view_patient_individual.php?p_id={$row_patient["p_id"]}'>View</a>
                        <a class='btn btn-danger' href='edit_patient.php?p_id={$row_patient["p_id"]}'>Edit</a></td>
                        
                        <td>{$row_patient["outcome_summary"]}</td>

                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='text-center'>No patients found in the database for the specified hospital.</p>";
        }

        $stmt->close();
    } else {
        echo "<p class='text-center'>Hospital ID not found in session or cookies.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

</div>
</main>

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
.container{
        padding-top: 20px;
}
main {
    padding-top: 20px;
    margin-left: -25%; /* or set it to a specific value like margin-left: 10px; */
    margin-right: 0; /* or set it to a specific value like margin-right: 10px; */
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
