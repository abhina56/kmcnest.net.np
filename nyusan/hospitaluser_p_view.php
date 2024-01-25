<?php
// Include the database connection file
include 'config.php';

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
    <title>View Patients</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-insert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <p></p>
</div>
<div class="container">
    <h2 class="text-center mb-4">View Patients</h2>

    <?php
    // Check if there are patients in the database
    if ($result_patient->num_rows > 0) {
        // Output table header
        echo "<table class='table table-bordered table-striped'>
                <tr>
                    <th>Patient ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Emergency Contact</th>
                    <th>Referred From</th>
                    <th>Document Path</th>
                    <th>Hospital ID</th>
                    <th>Bed Number</th>
                    <th>Admission Date</th>
                    <th>Discharge/Transfer Date</th>
                    <th>Status</th>
                    <th>Hospital Name</th>
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
                    <td>{$row_patient["phone"]}</td>
                    <td>{$row_patient["emergency_contact"]}</td>
                    <td>{$row_patient["referred_from"]}</td>
                    <td>{$row_patient["document_path"]}</td>
                    <td>{$row_patient["hospital_id"]}</td>
                    <td>{$row_patient["bed_no"]}</td>
                    <td>{$row_patient["admission_date"]}</td>
                    <td>{$row_patient["discharge_transfer_date"]}</td>
                    <td>{$row_patient["status"]}</td>
                    <td>{$hospital_name}</td>
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
    <a class='btn btn-success btn-insert' href='insert_p.php?hospital_id=<?php echo $hospital_id_from_url; ?>'>Insert Patient</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
