<?php
// Include the database connection file
include 'config.php';
include 'header.php';
// Define the date ranges
$currentDate = date('Y-m-d');
$startDateThisWeek = date('Y-m-d', strtotime('this week'));
$startDateThisMonth = date('Y-m-d', strtotime('first day of this month'));
$startDateThisQuarter = date('Y-m-d', strtotime('first day of this quarter'));
$startDateThisYear = date('Y-m-d', strtotime('first day of this year'));

// Function to count records within a date range
function countRecords($conn, $startDate, $endDate) {
    $sql = "SELECT COUNT(*) AS count FROM patient WHERE admission_date >= ? AND admission_date <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Count records for each date range
$countTodayAdded = countRecords($conn, $currentDate, $currentDate);
$countThisWeekAdded = countRecords($conn, $startDateThisWeek, $currentDate);
$countThisMonthAdded = countRecords($conn, $startDateThisMonth, $currentDate);
$countThisQuarterAdded = countRecords($conn, $startDateThisQuarter, $currentDate);
$countThisYearAdded = countRecords($conn, $startDateThisYear, $currentDate);

// You can do the same for discharge dates
// Define the date ranges for discharges
$endDateThisWeek = date('Y-m-d', strtotime('this week +6 days'));
$endDateThisMonth = date('Y-m-d', strtotime('last day of this month'));
$endDateThisQuarter = date('Y-m-d', strtotime('last day of this quarter'));
$endDateThisYear = date('Y-m-d', strtotime('last day of this year'));

// Function to count discharges within a date range
function countDischarges($conn, $startDate, $endDate) {
    $sql = "SELECT COUNT(*) AS count FROM patient WHERE discharge_transfer_date >= ? AND discharge_transfer_date <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

// Count discharges for each date range
$countTodayDischarged = countDischarges($conn, $currentDate, $currentDate);
$countThisWeekDischarged = countDischarges($conn, $currentDate, $endDateThisWeek);
$countThisMonthDischarged = countDischarges($conn, $startDateThisMonth, $endDateThisMonth);
$countThisQuarterDischarged = countDischarges($conn, $startDateThisQuarter, $endDateThisQuarter);
$countThisYearDischarged = countDischarges($conn, $startDateThisYear, $endDateThisYear);

// Close the database connection
$conn->close();
?>
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

        .card {
            margin-bottom: 20px;
        }

        .statistics-card {
            text-align: center;
        }

        .statistics-card .card-title {
            color: #007bff;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Patient Statistics</h2>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Added Today</h5>
                    <p class="card-text"><?php echo $countTodayAdded; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Added This Week</h5>
                    <p class="card-text"><?php echo $countThisWeekAdded; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Added This Month</h5>
                    <p class="card-text"><?php echo $countThisMonthAdded; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Added This Quarter</h5>
                    <p class="card-text"><?php echo $countThisQuarterAdded; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Added This Year</h5>
                    <p class="card-text"><?php echo $countThisYearAdded; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Discharged Today</h5>
                    <p class="card-text"><?php echo $countTodayDischarged; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Discharged This Week</h5>
                    <p class="card-text"><?php echo $countThisWeekDischarged; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Discharged This Month</h5>
                    <p class="card-text"><?php echo $countThisMonthDischarged; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Discharged This Quarter</h5>
                    <p class="card-text"><?php echo $countThisQuarterDischarged; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Discharged This Year</h5>
                    <p class="card-text"><?php echo $countThisYearDischarged; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Statistics Cards -->
<div class="col-md-4">
            <div class="card statistics-card">
                <div class="card-body">
                    <h5 class="card-title">Total Bill Generated</h5>
                    <p class="card-text">RS 50,000</p> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card statistics-card">
                <div class="card-body">
                    <h5 class="card-title">Total Bill Paid</h5>
                    <p class="card-text">RS 5,000</p> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card statistics-card">
                <div class="card-body">
                    <h5 class="card-title">Total Money Saved</h5>
                    <p class="card-text">RS 45,000</p> <!-- Replace with dynamic data -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
