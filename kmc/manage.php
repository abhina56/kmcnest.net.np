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
    <!-- Header with Image Background -->
    <div class="header">
        <h1>काठमाडौँ महानगरपालि</h1>
        <p>काठमाडौँ महानगरपालिका
लक्षित बर्ग निशुल्क उपचार सहजिकरण सेवा</p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <a class="navbar-brand" href="../index.php">KMC Care</a>
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
                    <?php if (isset($_SESSION['hospital_id']) || isset($_COOKIE['hospital_id'])): ?>
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>