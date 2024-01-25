<?php
include 'config.php';

// Retrieve patient ID from the URL
$p_id = $_GET['p_id'] ?? 0;

// Fetch patient data from the database
$sql_select_patient = "SELECT * FROM patient WHERE p_id = $p_id";
$result_patient = $conn->query($sql_select_patient);

if ($result_patient->num_rows > 0) {
    $patient_data = $result_patient->fetch_assoc();
} else {
    echo "Patient not found.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

    </style>
</head>
<body>
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
            <li><a href="hospital.php">Home</a></li>

            </ul>
        </div>
    </nav>
<br>
<br>
    <main><h2>Edit Patient Details</h2>
    <br>
    <form action="update_patient.php" method="post">
        <input type="hidden" name="p_id" value="<?php echo $patient_data['p_id']; ?>">

        <!-- Repeat this structure for each field -->
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient_data['name']; ?>">
        </div>
         <div class="form-group">
            <label for="name">Sex :</label>
            <select class="form-control" id="sex" name="sex" value="<?php echo $patient_data['sex']; ?>">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>            
          </div>
          <div class="form-group">
            <label for="name">Cast :</label>
            <select class="form-control" id="cast" name="cast" value="<?php echo $patient_data['cast']; ?>">
                <option value="">Brahmin/Chetteri</option>
            <option value="dalit">Dalit</option>
            <option value="janjati">Janajati</option>
            <option value="madeshi">Madheshi</option>
            <option value="muslim">Muslim</option>
            <option value="others">Others</option>
                </select>
        </div>
         <div class="form-group">
            <label for="name">DOB:</label>
            <input type="date" class="form-control" id="DOB" name="DOB" value="<?php echo $patient_data['DOB']; ?>">
        </div>
         <div class="form-group">
            <label for="name">Phone:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $patient_data['phone']; ?>">
        </div>
         <div class="form-group">
            <label for="name">Address :</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $patient_data['address']; ?>">
        </div>
         <div class="form-group">
            <label for="father_name">Father Name :</label>
            <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo $patient_data['father_name']; ?>">
        </div>
         <div class="form-group">
            <label for="name">Emergency Contact :</label>
            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="<?php echo $patient_data['emergency_contact']; ?>">
        </div>
        <div class="form-group">
            <label for="class">Class :</label>
            <select class="form-control" id="class" name="class" value="<?php echo $patient_data['class']; ?>">
                <option value="poor">Garib</option>
            <option value="helpless">Bipanna</option>
            <option value="aasahaya">Aasahaya</option>
            </select>
        </div>
         <div class="form-group">
            <label for="d_type">Disease Type :</label>
            <input type="text" class="form-control" id="d_type" name="d_type" value="<?php echo $patient_data['d_type']; ?>">
        </div>
         <div class="form-group">
            <label for="referred_from">Reefreed :</label>
            <select class="form-control" id="referred_from" name="referred_from" value="<?php echo $patient_data['referred_from']; ?>">
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
            <div class="form-group">
                <label for="bed_no">Bed no:</label>
                <input type="text" class="form-control" id="bed_no" id="bed_no" name="bed_no" value="<?php echo $patient_data['bed_no']; ?>">
            </div>
            <div class="form-group">
                <label for="admission_date">Admission Date:</label>
                <input type="text" class="form-control" id="admission_date" id="admission_date" name="admission_date" value="<?php echo $patient_data['admission_date']; ?>">
            </div>
            <div class="form-group">
                <label for="discharge_transfer_date">Discharge and Transfer Date:</label>
                <input type="date" class="form-control" id="discharge_transfer_date" id="bed_no" name="discharge_transfer_date" value="<?php echo $patient_data['discharge_transfer_date']; ?>">
            </div>
            
            <div class="form-group">
                <label for="bed_no">Bed no:</label>
                <input type="text" class="form-control" id="bed_no" id="bed_no" name="bed_no" value="<?php echo $patient_data['bed_no']; ?>">
            </div>
            <div class="form-grop">
                <label for="Total">Total :</label>
                <input type="text" class="form-control" id="total" id="total" name="total" value="<?php echo $patient_data['total']; ?>">
            </div>
            
            
            
        </div>
        <!-- Add other fields here `p_id`, `name`, `sex`, `cast`, `DOB`, `address`, `phone`, `emergency_contact`, `father_name`, `class`, `d_type`, `referred_from`, `document_path`, `hospital_id`, `bed_no`, `admission_date`, `discharge_transfer_date`, `bill_dir`, `total`, `paid`, `status`, `profile_picture_path` (sex, cast, DOB, etc.) -->
<br>
        <button type="submit" class="btn btn-primary" style="justify-content:center;">Update Patient</button>
    </form>
</div></main>

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
        /* Updated Navigation Styles */
        nav {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            padding: 0px 0; /* Adjust the top and bottom padding as needed */
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
h2{
    font-weight: bold;
}

            
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
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
