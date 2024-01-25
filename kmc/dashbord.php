<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="favicon.ico">

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
    
<!--        <header>-->
<!--    <div class="header-container">-->
<!--        <div class="logo-container">-->
<!--            <img src="cropped-logo.png" alt="Logo" width="150px" height="150px">-->
<!--        </div>-->
<!--        <div class="header-title">-->
<!--            <h1>काठमाडौँ महानगरपालिका</h1>-->
<!--            <h2>निशुल्क उपचार सहजिकरण सेवा</h2>-->
<!--        </div>-->
<!--        <div class="logo-container">-->
<!--            <img src="kmc-logo.png" alt="KMC Logo" width="150px" height="150px">-->
<!--        </div>-->
<!--    </div>-->
<!--</header>-->
    
<!--    <nav>-->
<!--        <ul>-->
<!--            <li><a href="hospital.php">Home</a></li>-->

<!--            </ul>-->
<!--        </div>-->
<!--    </nav>-->
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>

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

<?php
// Include the database connection file
include '../config.php';
// Filter options
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : "";
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : "";
$filter_patient_type = isset($_GET['filter_patient_type']) ? $_GET['filter_patient_type'] : "";
$filter_age_group = isset($_GET['filter_age_group']) ? $_GET['filter_age_group'] : "";


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
if ($filter_status === 'admitted') {
    $status_filter = "status = 'Admitted'";
} elseif ($filter_status === 'discharged') {
    $status_filter = "status = 'Discharged'";
}


// Define patient type filter
$patient_type_filter = "";
if ($filter_patient_type) {
    $patient_type_filter = "patient_type = '$filter_patient_type'";
}

// Define age group filter
$age_group_filter = "";
$current_year = date("Y");
if ($filter_age_group === 'children') {
    $age_group_filter = "YEAR(birth_date) >= " . ($current_year - 12);
} elseif ($filter_age_group === 'adults') {
    $age_group_filter = "YEAR(birth_date) BETWEEN " . ($current_year - 64) . " AND " . ($current_year - 18);
} elseif ($filter_age_group === 'seniors') {
    $age_group_filter = "YEAR(birth_date) <= " . ($current_year - 65);
}

// Construct the SQL query with filters
$sql_select_patient = "SELECT * FROM patient WHERE $date_filter";
if ($status_filter) {
    $sql_select_patient .= " AND ($status_filter)";
}
if ($patient_type_filter) {
    $sql_select_patient .= " AND ($patient_type_filter)";
}
if ($age_group_filter) {
    $sql_select_patient .= " AND ($age_group_filter)";
}

// Construct the SQL query with filters
$sql_select_patient = "SELECT * FROM patient WHERE $date_filter";
if ($status_filter !== "") {
    $sql_select_patient .= " AND ($status_filter)";
}

// $sql_select_patient = "SELECT * FROM patient WHERE $data_filter";
// if($hospital_filter){
//     $sql_select_patient .=" AND ($hospital_name_filter)"
// }

$stmt = $conn->prepare($sql_select_patient);
$stmt->execute();
$result_patient = $stmt->get_result();
?>
<div class="container">
    <h2 class="text-center mb-4">View Patients</h2>
</div>
    <!DOCTYPE html>
<html lang="en">
<head>
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
    </div>

<body>
    
    <div class="container">
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
                    <option value="Admitted">Admitted</option>
                    <option value="Discharged">Discharged</option>
                    <option vlaue="Death">Death</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Apply Filters</button>
        </form>
        <a href="dashbord4.php">
        <button class="btn btn-custom">Advance</button>
        </a>
    </div>
            <br>
        <br>

    <?php
    // Check if there are patients in the database
    if ($result_patient->num_rows > 0) {
        // Output table header
        echo "<table id='all-filter-data' class='table table-bordered table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Emergency Contact</th>
                    <th>Referred From</th>
                    <th>Hospital ID</th>
                    <th>Bed Number</th>
                    <th>Admission Date</th>
                    <th>Discharge/Transfer Date</th>
                    <th>Status</th>
                    <th>Hospital Name</th>
                    <th>Profile Picture</th>
                    <th>Action</th>
                </tr>";

while ($row_patient = $result_patient->fetch_assoc()) {
    $hospital_id = $row_patient["hospital_id"];

    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT hospital_name FROM hospital WHERE hospital_id = ?");
    $stmt->bind_param("i", $hospital_id); // 'i' specifies the variable type is integer

    // Execute the statement
    $stmt->execute();

    // Bind the result
    $result_hospital = $stmt->get_result();

    if ($result_hospital->num_rows > 0) {
        $hospital_data = $result_hospital->fetch_assoc();
        $hospital_name = $hospital_data['hospital_name'];
    } else {
        $hospital_name = '';
    }

            // Output patient data along with hospital name
            echo "<tr>
                    <td>{$row_patient["p_id"]}</td>
                    <td>{$row_patient["name"]}</td>
                    <td>{$row_patient["address"]}</td>
                    <td>{$row_patient["phone"]}</td>
                    <td>{$row_patient["emergency_contact"]}</td>
                    <td>{$row_patient["referred_from"]}</td>
                    <td>{$row_patient["hospital_id"]}</td>
                    <td>{$row_patient["bed_no"]}</td>
                    <td>{$row_patient["admission_date"]}</td>
                    <td>{$row_patient["discharge_transfer_date"]}</td>
                    <td>{$row_patient["status"]}</td>
                    <td>{$hospital_name}</td>
                    <td><img src='../{$row_patient['profile_picture_path']}' style='height: 100px; width: 100px;'></td>

                    <td><a class='btn btn-primary toggleGlowClasses' href='view_patient_individual.php?p_id={$row_patient["p_id"]}'>View</a></td>
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
    <button class='btn btn-success btn-insert' onclick="downloadTableAsExcel('all-filter-data', 'all-filter-data')">Download as Excel</button>
    

    <script>
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
        /* Updated Navigation Styles */
        nav {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 10px 0; /* Adjust the top and bottom padding as needed */
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
main {
        margin-left: 100px;
        margin-right: 100px;
    }
h2{
    font-weight:bold;
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
</div>
</body>
</html>
