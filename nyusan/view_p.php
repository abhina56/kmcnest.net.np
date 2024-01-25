<?php
// Include the database connection file
include 'config.php';
include 'header.php';
// Retrieve patient data from the database
$sql_select_patient = "SELECT * FROM patient";
$result_patient = $conn->query($sql_select_patient);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .table-container {
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

        .insert-link {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .insert-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mt-4">View Patients</h2>

    <div class="table-container">
<h2>View Patients</h2>

<?php
// Check if there are patients in the database
if ($result_patient->num_rows > 0) {
    // Output table header
    echo "<table>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Emergency Contact</th>
                <th> Pacent Type</th>
                <th>Referred From</th>
                <th>Document Path</th>
                <th>Hospital ID</th>
                <th>Bed Number</th>
                <th>Admission Date</th>
                <th>Discharge/Transfer Date</th>
                <th>Status</th>
            </tr>";

    // Output data of each row
    while ($row_patient = $result_patient->fetch_assoc()) {
        echo "<tr>
                <td>{$row_patient["p_id"]}</td>
                <td>{$row_patient["name"]}</td>
                <td>{$row_patient["address"]}</td>
                <td>{$row_patient["phone"]}</td>
                <td>{$row_patient["emergency_contact"]}</td>
                <td>{$row_patient["p_type"]}</td>
                <td>{$row_patient["referred_from"]}</td>
                <td>{$row_patient["document_path"]}</td>
                <td>{$row_patient["hospital_id"]}</td>
                <td>{$row_patient["bed_no"]}</td>
                <td>{$row_patient["admission_date"]}</td>
                <td>{$row_patient["discharge_transfer_date"]}</td>
                <td>{$row_patient["status"]}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "No patients found in the database.";
}

// Close the database connection
$conn->close();
?>
<a href="insert_p.php" class="insert-link">Insert Patient</a>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
