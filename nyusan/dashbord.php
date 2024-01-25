<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
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

        /* Define the glow classes */
        .glow-red {
            background-color: red;
            color: white;
        }

        .glow-orange {
            background-color: orange;
            color: white;
        }

        .glow-blink-red {
            animation: blink 1s step-start infinite;
        }

        @keyframes blink {
            50% {
                background-color: red;
                color: white;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to toggle the glow classes
            function toggleGlowClasses() {
                // Loop through all buttons with class 'toggleGlowClasses'
                $('.toggleGlowClasses').each(function () {
                    // Get the admission date from the data attribute
                    var admissionDate = new Date($(this).data('admission-date'));
                    var currentDate = new Date();

                    // Calculate the difference in days
                    var daysDifference = Math.floor((currentDate - admissionDate) / (1000 * 60 * 60 * 24));

                    // Remove existing glow classes
                    $(this).removeClass('glow-red glow-orange glow-blink-red');

                    // Check the conditions and add appropriate classes
                    if (daysDifference >= 10) {
                        $(this).addClass('glow-blink-red');
                    } else if (daysDifference >= 7) {
                        $(this).addClass('glow-red');
                    } else if (daysDifference >= 5) {
                        $(this).addClass('glow-orange');
                    }
                });
            }

            // Call the toggleGlowClasses function initially
            toggleGlowClasses();

            // Set an interval to toggle the glow classes every 1000 milliseconds (1 second)
            setInterval(function () {
                toggleGlowClasses();
            }, 1000);
        });
    </script>
</head>
<body>
<?php
// Include the database connection file
include 'config.php';
include 'header.php';
// Filter options
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : "";
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : "";

// Define date range based on filter options
switch ($filter_date) {
    case 'today':
        $date_filter = "DATE(admission_date) = CURDATE()";
        break;
    case 'this_week':
        $date_filter = "WEEK(admission_date) = WEEK(CURDATE())";
        break;
    case 'this_month':
        $date_filter = "MONTH(admission_date) = MONTH(CURDATE())";
        break;
    case 'this_year':
        $date_filter = "YEAR(admission_date) = YEAR(CURDATE())";
        break;
    default:
        $date_filter = "1"; // Show all records if no date filter is selected
}

// Define status filter
$status_filter = "";
if ($filter_status === 'active') {
    $status_filter = "status = 'Active'";
} elseif ($filter_status === 'inactive') {
    $status_filter = "status = 'Inactive'";
}

// Construct the SQL query with filters
$sql_select_patient = "SELECT * FROM patient WHERE $date_filter";
if ($status_filter !== "") {
    $sql_select_patient .= " AND ($status_filter)";
}

$stmt = $conn->prepare($sql_select_patient);
$stmt->execute();
$result_patient = $stmt->get_result();
?>
<div class="container">
    <h2 class="text-center mb-4">View Patients</h2>

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: #007bff;
        }

        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            margin-top: 20px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .filter-label {
            margin-right: 10px;
        }

        .filter-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="#">Patient Management System</a>
            <!-- Add additional navbar items if needed -->
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center mb-4">View Patients</h2>

        <!-- Filter options -->
        <form method="GET" class="d-flex justify-content-between align-items-center filter-form">
            <div>
                <label class="filter-label" for="filter_date">Filter by Admission Date:</label>
                <select name="filter_date" id="filter_date" class="form-control">
                    <option value="">All</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                    <option value="this_year">This Year</option>
                </select>
            </div>
            <div>
                <label class="filter-label" for="filter_status">Filter by Status:</label>
                <select name="filter_status" id="filter_status" class="form-control">
                    <option value="">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Apply Filters</button>
        </form>
        
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
                    <td><a class='btn btn-primary toggleGlowClasses' data-admission-date='{$row_patient["admission_date"]}' href='view_patient.php?p_id={$row_patient["p_id"]}'>View</a></td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='text-center'>No patients found in the database for the specified filters.</p>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <!-- "Insert Patient" button -->
    <a class='btn btn-success btn-insert' href='insert_p.php'>Insert Patient</a>
</div>
</body>
</html>
