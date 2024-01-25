<?php
include '../config.php';

// Retrieve patient ID from the URL
$p_id = $_GET['p_id'] ?? 0;

// Retrieve patient data from the database
$sql_select_patient = "SELECT * FROM patient WHERE p_id = $p_id";
$result_patient = $conn->query($sql_select_patient);

// Check if patient exists
if ($result_patient->num_rows > 0) {
    $row_patient = $result_patient->fetch_assoc();

    // Retrieve hospital name for the current patient
    $hospital_id = $row_patient["hospital_id"];
    $sql_select_hospital = "SELECT hospital_name FROM hospital WHERE hospital_id = $hospital_id";
    $result_hospital = $conn->query($sql_select_hospital);
    $hospital_name = ($result_hospital->num_rows > 0) ? $result_hospital->fetch_assoc()["hospital_name"] : '';
} else {
    echo "Patient not found.";
    exit();
}
$billFiles = explode(',', $row_patient["bill_dir"]);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient</title>
          <link rel="icon" type="image/x-icon" href="favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>/* Color Palette */
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

        .container {
            max-width: 800px;
            margin-top: 20px;
        }

        .btn-action {
            margin-right: 10px;
            border-radius:10%;

        }
        .upbill {
            margin-bottom: 20px;
        }
                body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

       /* Updated Navigation Styles */
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
    <nav>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <!--<li><a href="files.php"><i class="fas fa-download"></i> Download</a></li>-->
            <!--<li class="nav-item">-->
                    <!-- Toggle between Logout and Login based on session status -->
            <!--        <?php if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])): ?>-->
            <!--            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>-->
            <!--        <?php else: ?>-->
            <!--            <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>-->
            <!--        <?php endif; ?>-->
            <!--    </li>-->
            </ul>
        </div>
    </nav>
<br>
<br>
<h2 align="center"><emp>View Patients</emp></h2>

<table>
    <tr>
        <th>Patient ID</th>
        <td><?php echo $row_patient["p_id"]; ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?php echo $row_patient["name"]; ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php echo $row_patient["address"]; ?></td>
    </tr>
    <tr>
        <th>Phone</th>
        <td><?php echo $row_patient["phone"]; ?></td>
    </tr>
    <tr>
        <th>Patient Type</th>
        <td><?php echo $row_patient["d_type"]; ?></td>
    </tr>
    <tr>
        <th>Emergency Contact</th>
        <td><?php echo $row_patient["emergency_contact"]; ?></td>
    </tr>
    <tr>
        <th>Referred From</th>
        <td><?php echo $row_patient["referred_from"]; ?></td>
    </tr>
    <tr>
    <th>Document</th>
    <td><img src="<?php echo $row_patient["document_path"]; ?>" alt="Patient Document"></td>
    </tr>

    <tr>
        <th>Hospital ID</th>
        <td><?php echo $row_patient["hospital_id"]; ?></td>
    </tr>
    <tr>
        <th>Bed Number</th>
        <td><?php echo $row_patient["bed_no"]; ?></td>
    </tr>
    <tr>
        <th>Admission Date</th>
        <td><?php echo $row_patient["admission_date"]; ?></td>
    </tr>
    <tr>
        <th>Discharge/Transfer Date</th>
        <td><?php echo $row_patient["discharge_transfer_date"]; ?></td>
    </tr>
    <tr>
        <th>Total Bill</th>
        <td><?php echo $row_patient["total"]; ?></td>
    </tr>

    <tr>
        <tr>
    <th>Profile Picture</th>
    <td>
        <?php if (!empty($row_patient["profile_picture_path"])): ?>
            <img src="<?php echo htmlspecialchars($row_patient["profile_picture_path"]); ?>" alt="Profile Picture" style="width: 150px; height: auto;">
        <?php else: ?>
            <p>No profile picture available.</p>
        <?php endif; ?>
    </td>
</tr>

   <tr>
    <th>Bill Files</th>
    <td>
        <?php foreach ($billFiles as $file): ?>
            <?php if (!empty($file)): ?>
                <a href="<?php echo htmlspecialchars($file); ?>" target="_blank"><?php echo htmlspecialchars(basename($file)); ?></a><br>
            <?php endif; ?>
        <?php endforeach; ?>
    </td>
    <tr>
    <tr>
        <th>Status</th>
        <td><?php echo $row_patient["status"]; ?></td>
    </tr>
    <tr>
        <th>Hospital Name</th>
        <td><?php echo $hospital_name; ?></td>
    </tr>
</table>


<div class="modal" id="referModal">
<div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Refer to Hospital</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="refer_patient.php" method="post">
                    <div class="form-group">
                        <label for="hospitalName">Select Hospital:</label>
                        <select class="form-control" id="hospitalName" name="hospitalName">
                            <!-- Populate options with hospital names from the database -->
                            <?php
                            include 'config.php'; // Make sure the path is correct
                            $sql_select_hospitals = "SELECT hospital_id, hospital_name FROM hospital";
                            $result_hospitals = $conn->query($sql_select_hospitals);
                            if ($result_hospitals) {
                                while ($row_hospital = $result_hospitals->fetch_assoc()) {
                                    echo "<option value='{$row_hospital["hospital_id"]}'>{$row_hospital["hospital_name"]}</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="patientId" value="<?php echo $p_id; ?>"> <!-- Assuming $p_id is the patient's ID -->
                    <button type="submit" class="btn btn-primary">Refer</button>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<form action="update_bill.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="patientId" value="<?php echo $row_patient["p_id"]; ?>">

    <div class="form-group">
            <label for="totalCost">Total Bill:</label>
            <input type="number" class="form-control" id="totalCost" name="totalCost" required>
        </div>


    <div class="form-group">
        <label for="billFile">Upload Bill:</label>
        <input type="file" class="form-control" id="billFile" accept=".pdf,.jpg,.jpeg,.png" name="billFiles[]" multiple >
    </div>

    <button type="submit" class="btn upbill btn-primary">Update Bill</button>
</form>

<div>
    <button class="btn btn-primary btn-action" data-toggle="modal" data-target="#referModal">Refer to Hospital</button>

    <!-- Button to set status as inactive -->
<a class="btn btn-danger btn-action" onclick="confirmDischarge(<?php echo $row_patient['p_id']; ?>)">Discharge</a>
<!-- Button to set status as Dead -->
<a class="btn btn-danger btn-action" onclick="confirmDeath(<?php echo $row_patient['p_id']; ?>)">Dead</a>

         </div>

<br>



<a href="hospital.php">Back</a>
<script>
    function confirmDischarge(p_id) {
        var confirmAction = confirm("Are you sure you want to discharge this patient?");
        if (confirmAction) {
            var dischargeDate = prompt("Please enter the discharge date (YYYY-MM-DD):");
            if (dischargeDate) {
                window.location.href = "set_status.php?p_id=" + p_id + "&status=inactive&date=" + dischargeDate;
            }
        }
    }

    function confirmDeath(p_id) {
        var confirmAction = confirm("Are you sure you want to declare this patient dead?");
        if (confirmAction) {
            var doubleCheck = confirm("Please confirm again if you want to declare the patient dead.");
            if (doubleCheck) {
                var deathDate = prompt("Please enter the death date (YYYY-MM-DD):");
                if (deathDate) {
                    window.location.href = "set_status.php?p_id=" + p_id + "&status=Dead&date=" + deathDate;
                }
            }
        }
    }
</script>
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
