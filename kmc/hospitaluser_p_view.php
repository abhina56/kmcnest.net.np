<?php
// Include the database connection file
include '../config.php';

// Check if hospital_id is in the URL parameter
$hospital_id_from_url = isset($_GET['hospital_id']) ? $_GET['hospital_id'] : null;

// If hospital_id is not in the URL, check if it's in the session
if ($hospital_id_from_url === null && isset($_SESSION['hospital_id'])) {
    $hospital_id_from_session = $_SESSION['hospital_id'];
} else {
    $hospital_id_from_session = $hospital_id_from_url; // Use the one from the URL if available
}

// Now you can use $hospital_id_from_session in your code
// For example, to display it or use it in database queries

// Retrieve patient data from the database for the specific hospital ID
$sql_select_patient = "SELECT * FROM patient WHERE hospital_id = ?";
$stmt = $conn->prepare($sql_select_patient);
$stmt->bind_param('i', $hospital_id_from_url);
$stmt->execute();
$result_patient = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

    <title>View Hospitals</title>
      <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }
        .navbar-custom {
            background-color: #007bff; /* Blue theme for navbar */
            color: white;
        }
        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }
        .navbar-custom .nav-link:hover {
            color: #aaa;
        }
        .header {
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            height: 200px;
            color: white;
            text-align: center;
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
        <a class="navbar-brand" href="index.php">KMC Care</a>
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
    <p></p>
</div>
<div class="container">
    <h2 class="text-center mb-4">View Patients</h2>

    <?php
    // Check if there are patients in the database
    if ($result_patient->num_rows > 0) {
        // Output table header
        echo "<table id='hospital-p-table' class='table table-bordered table-striped'>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Emergency Contact</th>
                    <th>Referred From</th>
                    <th>Bed Number</th>
                    <th>Admission Date</th>
                    <th>Discharge/Transfer Date</th>
                    <th>Status</th>
                    <th>Hospital Name</th>
                    <th>Profile</th>
                    <th>Action</th>
                </tr>";

        // Output data of each row
        while ($row_patient = $result_patient->fetch_assoc()) {
            // Retrieve hospital name for the current patient
            $hospital_id = $row_patient["hospital_id"];
            $sql_select_hospital = "SELECT hospital_name FROM hospital WHERE hospital_id = $hospital_id";
            $result_hospital = $conn->query($sql_select_hospital);
            $hospital_name = ($result_hospital->num_rows > 0) ? $result_hospital->fetch_assoc()["hospital_name"] : '';

            // Output patient data along with hospital name
            echo "<tr>
                    <td>{$row_patient["p_id"]}</td>
                    <td>{$row_patient["name"]}</td>
                    <td>{$row_patient["address"]}</td>
                    <td>{$row_patient["emergency_contact"]}</td>
                    <td>{$row_patient["referred_from"]}</td>
                    <td>{$row_patient["bed_no"]}</td>
                    <td>{$row_patient["admission_date"]}</td>
                    <td>{$row_patient["discharge_transfer_date"]}</td>
                    <td>{$row_patient["status"]}</td>
                    <td>{$hospital_name}</td>
                    <td><img src='{$row_patient["profile_picture_path"]}'></td>

                    <td><a class='btn btn-primary' href='view_patient_individual.php?p_id={$row_patient["p_id"]}'>View</a></td>
                </tr>";
        }

        echo "</table>";
        
    } else {
        echo "<p class='text-center'>No patients found in the database for the specified hospital.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <!-- "Insert Patient" button -->
    <a class='btn btn-success btn-insert' href='insert_p.php?hospital_id=<?php echo $hospital_id_from_url; ?>'>Add Patient</a>
    <button class='btn btn-success btn-insert' onclick="downloadTableAsExcel('hospital-p-table', 'hospital-p-table')">Download as Excel</button>

</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function downloadTableAsExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}

    
</script>
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
