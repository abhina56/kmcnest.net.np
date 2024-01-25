<?php

// Include the database connection file
include 'config.php';

include 'assets/header.php';
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
    <title>View Hospitals</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    No of Hospital: <?php echo $row_count; ?>
</div>
<div class="container">
    <h2 class="mt-4">View Hospitals</h2>

    <?php
    // Check if there are hospitals in the database
    if ($result->num_rows > 0) {
        // Output table header
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
                    <th>Password</th>
                    <th>View</th>
                </tr>";

        // Output data of each row
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
                    <td>{$row["hashedPassword"]}</td>
                    <td><a href='hospitaluser_p_view.php?hospital_id={$row["hospital_id"]}'>View</a></td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "No hospitals found in the database.";
    }

    // Close the database connection
    $conn->close();
    ?>

    <a href="insert_hospital.php" class="btn btn-primary">Insert Hospital Detail</a>
</div>

<!-- Bootstrap JS and dependencies (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
