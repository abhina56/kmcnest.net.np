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
        table{
            margin-left: 0px;
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
        .container{
            margin-left: 0px;
        }
        .header {
            background-image: url('https://kathmandu.gov.np/wp-content/themes/kmc-theme/images/header-new.png'); /* Add your image URL here */
            background-size: cover;
            background-position: center;
            height: 200px;
            color: black;
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
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
}

.card-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
}

.card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 10px;
    width: 150px; /* or any other fixed width */
    overflow: hidden;
}

/*.card:hover {*/
    /*background-color: #808080;*/
    /*border-radius: 8px;*/
    /*box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
    /*margin: 10px;*/
    /*width: 200px; */
    /* or any other fixed width */
    /*overflow: hidden;*/
/*}*/

.card-img-top {
    width: 100%;
    height: auto;
}

.card-body {
    padding: 15px;
}

.card-title {
    font-size: 1.25em;
    margin-bottom: 15px;
}

.card-text {
    font-size: 1em;
    margin-bottom: 15px;
}

.btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
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
        <!--<a class="navbar-brand" href="../index.php">Home</a>-->
        <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">-->
        <!--    <span class="navbar-toggler-icon"></span>-->
        <!--</button>-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" href="bill_statistics.php"><i class="fas fa-chart-bar"></i> Bill Statistics</a>-->
                <!--</li>-->
                <li class="nav-item">
                    <a class="nav-link" href="uploads.php"><i class="fas fa-upload"></i> Uploads</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="monitor.php"><i class="fas fa-desktop"></i> Monitor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-cog"></i> Manage</a>
                </li>
                <li class="nav-item">
                    <!-- Toggle between Logout and Login based on session status -->
                    <?php if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])): ?>
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <?php else: ?>
                        <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
    <br>
    <br>
    <main>
    <div class="container">
        <?php
// Assuming you have a database connection established in $conn
        include '../config.php';
// Query to get the total number of beds
$sql_total_beds = "SELECT SUM(total_bed) AS total_beds FROM hospital";
$result_total_beds = $conn->query($sql_total_beds);
$total_beds = $result_total_beds->fetch_assoc()['total_beds'];

 // Calculate 10% of the total beds
    $ten_percent_beds = $total_beds * 0.1;

// Query to get the number of occupied beds (active patients)
$sql_occupied_beds = "SELECT COUNT(*) AS occupied_beds FROM patient WHERE status = 'Admitted'";
$result_occupied_beds = $conn->query($sql_occupied_beds);
$occupied_beds = $result_occupied_beds->fetch_assoc()['occupied_beds'];

// Calculate unoccupied beds
$unoccupied_beds = $ten_percent_beds - $occupied_beds;

// Query to get long stay patients
$sql_long_stay = "SELECT COUNT(*) AS long_stay FROM patient WHERE status = 'Admitted' AND DATEDIFF(CURDATE(), admission_date) > 7";
$result_long_stay = $conn->query($sql_long_stay);
$long_stay = $result_long_stay->fetch_assoc()['long_stay'];

// Query to get the number of dead patients
$sql_dead_patients = "SELECT COUNT(*) AS dead_patients FROM patient WHERE status = 'Death'";
$result_dead_patients = $conn->query($sql_dead_patients);
$dead_patients = $result_dead_patients->fetch_assoc()['dead_patients'];

// Query to get long stay patients (more than 7 days and active) ('Admitted', 'Discharged', 'Death')
$sql_long_stay = "SELECT COUNT(*) AS long_stay FROM patient WHERE status = 'Admitted' AND DATEDIFF(CURDATE(), admission_date) > 7";
$result_long_stay = $conn->query($sql_long_stay);
$long_stay = $result_long_stay->fetch_assoc()['long_stay'];

// Display the results
echo "
    <div class='card-container'>
        <div class='card'>
            <img src='bed.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>Total Hospital Bed</h5>
                <p class='card-text'> $total_beds </p>
            </div>
        </div>
        
        <div class='card'>
            <img src='10bed.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>10% Hospital Bed</h5>
                <p class='card-text'> $ten_percent_beds </p>
            </div>
        </div>
        <div class='card'>
            <img src='death.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>Unoccupied Hospital Bed</h5>
                <p class='card-text'> $unoccupied_beds </p>
            </div>
        </div>
         <div class='card'>
            <img src='occ.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>Occupied Hospital Bed</h5>
                <p class='card-text'> $occupied_beds </p>
            </div>
        </div>
        <div class='card'>
            <img src='dead.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>Death</h5>
                <p class='card-text'> $dead_patients </p>
            </div>
        </div>
          <div class='card'>
            <img src='poor_hospital.png' alt='Hospital Image' class='card-img-top'>
            <div class='card-body'>
                <h5 class='card-title'>Long stay 7 days and above</h5>
                <p class='card-text'> $long_stay </p>
            </div>
        </div>
    <!-- Add more cards as needed -->
</div>
";
?>
<br>
<br>
</main>

        <?php
        // Include the database connection file
        include '../config.php';

        // Retrieve hospital data from the database
        $sql_select = "SELECT h.*, COUNT(p.p_id) AS active_patients, ROUND(0.1 * h.total_bed) AS allocated_beds
                       FROM hospital h
                       LEFT JOIN patient p ON h.hospital_id = p.hospital_id AND p.status = 'Active'
                       GROUP BY h.hospital_id";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            echo "<table id='hospital_kmc' class='table table-bordered table-custom'>
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
            <a href="insert_hospital.php" class="btn btn-custom"> Add Hospital Detail</a>
            <button class="btn btn-custom" onclick="downloadTableAsExcel('hospital_kmc', 'hospital-data')">Download as Excel</button>

        </div>
    </div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Example of JavaScript if you need any interactivity
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.btn');

    buttons.forEach(btn => {
        btn.addEventListener('mouseover', () => {
            btn.style.backgroundColor = '#0069d9'; // Darken button on hover
        });

        btn.addEventListener('mouseout', () => {
            btn.style.backgroundColor = '#007bff'; // Revert button color on mouse out
        });
    });
});

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
main{
    margin-left:60px;
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
