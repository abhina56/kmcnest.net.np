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
            background-color: #f4f4f4;
        }
        .container {
            padding-top: 20px;
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
    <div class="container">
        <h2 class="text-center mb-4">View Hospitals</h2>

        <?php
        // Include the database connection file
        include 'config.php';

        // Retrieve hospital data from the database
        $sql_select = "SELECT h.*, COUNT(p.p_id) AS active_patients, ROUND(0.1 * h.total_bed) AS allocated_beds
                       FROM hospital h
                       LEFT JOIN patient p ON h.hospital_id = p.hospital_id AND p.status = 'Active'
                       GROUP BY h.hospital_id";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered table-custom'>
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
                        <th>Hashed Password</th>
                        <th>View</th>
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
                        <td>{$row["hashedPassword"]}</td>
                        <td><a href='hospitaluser_p_view.php?hospital_id={$row["hospital_id"]}' class='btn btn-info btn-sm'>View</a></td>
                    </tr>";
            }

            echo "</table>";
        } else {
            echo "<p class='text-center'>No hospitals found in the database.</p>";
        }

        // Close the database connection
        $conn->close();
        ?>

        <div class="text-center">
            <a href="insert_hospital.php" class="btn btn-custom">Insert Hospital Detail</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
