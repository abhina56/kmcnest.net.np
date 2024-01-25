<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Stat</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    
       /* Color Palette */
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

/* Header */
header {
    background: var(--primary-color);
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

.logo-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10%;
}

.header-title h1 {
    text-align: center;
}
.navbar-custom {
            background-color: #007bff; /* Blue theme */
            color: white;
        }

.navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: white;
        }

.navbar-custom .nav-link:hover {
            color: #aaa;
        }

/* Sidebar Navigation */
aside {
    width: 200px;
    background-color: var(--secondary-color);
    height: 100vh;
    position: fixed;
}

aside nav ul {
    list-style: none;
    padding: 20px;
}

aside nav ul li a {
    color: white;
    text-decoration: none;
    display: block;
    padding: 10px;
    transition: background 0.3s;
}

aside nav ul li a:hover {
    background-color: var(--accent-color);
}

/* Main Content */
main {
    margin-left: 200px;
    margin-right: 200px;
    flex-grow: 1;
    padding: 20px;
}
.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10%;
}

/* Responsive Design */
@media (max-width: 768px) {
    aside {
        width: 100px;
    }

    aside nav ul li a {
        padding: 5px;
    }

    main {
        margin-left: 100px;
    }

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
    </style>
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
            
        }
        
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10%;
}
.header-title h1, .header-title h2 {
font-weight:600;
    
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
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo-container">
            <img src="cropped-logo.png" alt="Logo" width="150px" height="150px">
        </div>
        <div class="header-title">
            <br><h1>काठमाडौँ महानगरपालिका</h1>
            <h2>निशुल्क उपचार सहजिकरण सेवा</h2>
        </div>
        <div class="logo-container">
            <img src="kmc-logo.png" alt="KMC Logo" width="150px" height="150px">
        </div>
    </div>
</header>
<nav>
    <ul>
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
            <a class="nav-link" href="index.php"><i class="fas fa-cog"></i> Manage</a>
        </li>
        <li class="nav-item">
            <?php if (isset($_SESSION['hospital_id']) || isset($_COOKIE['hospital_id'])): ?>
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            <?php else: ?>
                <a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>


    
    
    
    
    <?php
    
// Initialize an empty array for conditions
$conditions = [];

    // Construct the SQL query
$sql = "SELECT * FROM patient";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

// Execute the query and check for errors
$result_patient = $conn->query($sql);
if (!$result_patient) {
    die("Error executing query: " . $conn->error);
}

    include '../config.php';
    if (isset($result_patient) && $result_patient->num_rows > 0) {
        echo "<table id='all-filter-data' border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Patient Type</th>
                    <th>Emergency Contact</th>
                    <th>Referred From</th>
                    <th>Hospital ID</th>
                    <th>Bed Number</th>
                    <th>Admission Date</th>
                    <th>Discharge/Transfer Date</th>
                    <th>Hospital Name</th>
                    <th>Status</th>
                    <th>Bill Amount</th>
                    <th>Action</th>
                </tr>";
while ($row = $result_patient->fetch_assoc()) {
    $hospital_id = $row["hospital_id"];

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

            
            
            echo "<tr>
                    <td>{$row["p_id"]}</td>
                    <td>{$row["name"]}</td>
                    <td>{$row["address"]}</td>
                    <td>{$row["phone"]}</td>
                    <td>{$row["d_type"]}</td>
                    <td>{$row["emergency_contact"]}</td>
                    <td>{$row["referred_from"]}</td>
                    <td>{$row["hospital_id"]}</td>
                    <td>{$row["bed_no"]}</td>
                    <td>{$row["admission_date"]}</td>
                    <td>{$row["discharge_transfer_date"]}</td>
                    <td>{$hospital_name}</td>
                    <td>{$row["status"]}</td>
                    <td>{$row["total"]}</td>

                    <td><a class='btn btn-primary toggleGlowClasses' data-admission-date='{$row["admission_date"]}' href='view_patient_individual.php?p_id={$row["p_id"]}'>View</a></td>

                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No patients found for the specified filters.</p>";
    }
    ?>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    
    
    
    
    
    
    
    
    <a class='btn btn-success btn-insert' href='insert_p.php'>Add Patient</a>
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
nav {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 10px 0;
        }


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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            
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

<?php
$conn->close();
?>