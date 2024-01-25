<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Hospitals</title>
      <link rel="icon" type="image/x-icon" href="favicon.ico">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>


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
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="uploads.php"><i class="fas fa-upload"></i> Uploads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="monitor.php"><i class="fas fa-desktop"></i> Monitor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-cog"></i> Manage</a>
                </li>
                <li class="nav-item">
                    <!-- Toggle between Logout and Login based on session status -->
                    <?php session_start(); ?>
                    <?php if (isset($_SESSION['hospital_id']) || isset($_COOKIE['hospital_id'])): ?>
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
    <?php
// Include the database connection file
include '../config.php';
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

<?php include 'dashbord.php'; ?>
<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    