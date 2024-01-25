<?php session_start(); ?>
<?php
include '../config.php';

// Initialize an empty array for conditions
$conditions = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if name is provided
    if (!empty($_POST['name'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $conditions[] = "name LIKE '%$name%'";
    }
    // Check if address is provided
    if (!empty($_POST['address'])) {
        $address = $conn->real_escape_string($_POST['address']);
        $conditions[] = "address LIKE '%$address%'";
    }
    // Check if status is provided
    if (!empty($_POST['status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conditions[] = "status = '$status'";
    }
    // Check if hospital id is provided
    if (!empty($_POST['hospital_id'])) {
        $hospital_id = $conn->real_escape_string($_POST['hospital_id']);
        $conditions[] = "hospital_id = '$hospital_id'";
    }
        // Check if from date is provided
    if (!empty($_POST['from_date'])) {
        $from_date = $conn->real_escape_string($_POST['from_date']);
        $conditions[] = "admission_date >= '$from_date'";
    }
    // Check if to date is provided
    if (!empty($_POST['to_date'])) {
        $to_date = $conn->real_escape_string($_POST['to_date']);
        $conditions[] = "admission_date <= '$to_date'";
    }
}

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

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Search in PHP</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <style>
#hospitalList {
    list-style-type: none;
    padding: 0;
    position: absolute;
    z-index: 1;
}

#hospitalList li {
    padding: 10px;
    background: white;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
}

#hospitalList li:hover {
    background-color: #f0f0f0;
}
.form-inline .form-control {
            width: auto; /* Adjust this as needed */
        }
</style>
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
                    <?php if (isset($_SESSION['hospital_id']) || isset($_COOKIE['hospital_id'])): ?>
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
        <h2>Search Patients</h2>
        <form method="POST" class="mb-4">
            <div class="row form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name">
            
            
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address">
            
            
                <label for="status">Status:</label>
                <select class="form-control" name="status">
                    <option value="Admitted">Admitted</option>
                    <option value="Discharged">Discharged</option>
                    <option value="Death">Death</option>
                </select>
            
             <!-- From Date -->
        <label for="from_date">From:</label>
        <input class="form-control" type="date" id="from_date" name="from_date">

        <!-- To Date -->
        <label for="to_date">To:</label>
        <input class="form-control" type="date" id="to_date" name="to_date">

            
            <label for="hospital_name">Hospital Name:</label>
            <input type="text" class="form-control" id="hospital_name" name="hospital_name" autocomplete="off">
            <div id="hospitalList" class="autocomplete-list"></div>
        
            </div>
            <input type="hidden" id="hospital_id" name="hospital_id">
            <button type="submit" class="btn btn-primary" style="margin-left:250px;
">Search</button>
        </form>

    <?php
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
                    <td><a class='btn btn-primary toggleGlowClasses' data-admission-date='{$row["admission_date"]}' href='view_patient_individual.php?p_id={$row["p_id"]}'>View</a></td>

                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No patients found for the specified filters.</p>";
    }
    ?>
    <br>
    <br>
    



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    $("#hospital_name").keyup(function() {
        var query = $(this).val();
        if (query != '') {
            $.ajax({
                url: "search_hospital.php",
                method: "POST",
                data: {query: query},
                success: function(data) {
                    $('#hospitalList').fadeIn();
                    $('#hospitalList').html(data);
                }
            });
        } else {
            $('#hospitalList').fadeOut();
            $('#hospitalList').html("");
        }
    });

    $(document).on('click', 'li', function() {
        $('#hospital_name').val($(this).text());
        $('#hospital_id').val($(this).data('value'));
        $('#hospitalList').fadeOut();
    });
});
</script>

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
    </main>
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
        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight:bold;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }
table{
    margin-left:50px;
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
