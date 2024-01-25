<?php
include 'config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

function confirmUser($message) {
    echo "<script>";
    echo "var userConfirmation = confirm('" . addslashes($message) . "');";
    echo "return userConfirmation;";
    echo "</script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $address1 = $_POST['address1'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $emergency_contact = $_POST['emergency_contact'] ?? '';
    $referred_from = $_POST['referred_from'] ?? '';
    $sex = $_POST['sex'] ?? '';
    $class = $_POST['class'] ?? '';
    $father_name = $_POST['father_name'] ?? '';
    $cast = $_POST['cast'] ?? '';
    $d_department = $_POST['d_department'] ?? '';
    $d_type = $_POST['d_type'] ?? 'Normal';
    $bed_no = $_POST['bed_no'] ?? '';
    $admission_date = $_POST['admission_date'] ?? '';
    $status = $_POST['status'] ?? 'Admitted';
    $national_id_no = $_POST['national_id_no'] ?? '';
    $profile_picture_path = $_POST['profile_picture_path'] ?? '';
    $total_expenses = $_POST['total_expenses'] ?? '';
    $outcome_summary = $_POST['outcome_summary'] ?? '';
    $province = isset($_POST['province']) ? $_POST['province'] : '';
    $dob = $_POST['dob'] ?? '';
    $district = isset($_POST['district']) ? $_POST['district'] : '';
    $municipality = isset($_POST['municipality']) ? $_POST['municipality'] : '';

    // Concatenate the values into a single string
    $fullAddress = $province . ", " . $district . ", " . $municipality . ", " . $address1;

    $hospital_id = $_SESSION['hospital_id'] ?? null; // Set to null if not set

    // Check if hospital_id is valid
    if (is_null($hospital_id) || $hospital_id === 0) {
        // Handle error - Redirect or show a message
        echo "Invalid hospital ID. Login again Session expired.";
        header("Location: login.php");
        exit();
    }

    $document_path = '';
    $uploadOk = 1;

    if (isset($_FILES["document"])) {
        $uploadDirectory = 'uploads/';
        $targetFile = $uploadDirectory . basename($_FILES["document"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file size and type
        if ($_FILES["document"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "pdf") {
            echo "Sorry, only JPG, JPEG, PNG, & PDF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
                $document_path = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Handle profile picture upload
    $profilePicturePath = '';  // Default value if no file is uploaded

    if (isset($_FILES["profile_picture_path"]) && $_FILES["profile_picture_path"]["error"] == 0) {
        $profilePicture = $_FILES["profile_picture_path"];
        $fileName = time() . '_' . basename($profilePicture['name']); // Create a unique file name
        $targetDirectory = 'upload_profil/'; // Directory where files will be uploaded
        $targetFile = $targetDirectory . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate file size (e.g., 5MB max)
        if ($profilePicture['size'] > 5000000) {
            echo "Sorry, your profile picture is too large.";
            $uploadOk = 0;
        }

        // Validate file type (e.g., only jpg, jpeg, png allowed)
        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
            echo "Sorry, only JPG, JPEG, PNG files are allowed for profile pictures.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your profile picture was not uploaded.";
            // Try to upload file
        } else {
            if (move_uploaded_file($profilePicture['tmp_name'], $targetFile)) {
                $profilePicturePath = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your profile picture.";
            }
        }
    }


$enabled = false;
        // Check redundancy based on dob, name, and father_name
$checkQuery = "SELECT admission_date FROM patient WHERE DOB = ? AND name = ? AND father_name = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param('sss', $dob, $name, $father_name);
$checkStmt->execute();
$checkStmt->store_result();

// Check redundancy based on national ID
$checkNationalIdQuery = "SELECT admission_date FROM patient WHERE national_id_no = ? AND admission_date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
$checkNationalIdStmt = $conn->prepare($checkNationalIdQuery);
$checkNationalIdStmt->bind_param('s', $national_id_no);
$checkNationalIdStmt->execute();
$checkNationalIdStmt->store_result();

// Initialize JavaScript variables
echo '<script>';
echo 'var alertNationalIdMessage = "";';
echo 'var alertMessage = "";';
echo '</script>';

if ($checkNationalIdStmt->num_rows > 0) {
    $checkNationalIdStmt->bind_result($previousAdmissionDate);

    echo '<script>';
    echo 'alertNationalIdMessage = "Patient with the same National ID Number has been entered in the last 1 year. Admission dates:\\n";';

    while ($checkNationalIdStmt->fetch()) {
        echo 'alertNationalIdMessage += "'.$previousAdmissionDate.', ";';
    }

    echo 'alert(alertNationalIdMessage);';
    echo '</script>';

    $checkNationalIdStmt->close();
}

if ($checkStmt->num_rows > 0) {
    $checkStmt->bind_result($previousAdmissionDate);

    echo '<script>';
    echo 'alertMessage = "Patient with the same DOB, name, and father_name already exists. Previous admission dates:\\n";';

    while ($checkStmt->fetch()) {
        echo 'alertMessage += "'.$previousAdmissionDate.', ";';
    }

    echo 'alert(alertMessage);';
    echo '</script>';
    
    $enabled = true;
}else{
            // Continue with your existing code to insert the data
            $sql_insert = "INSERT INTO patient (name, address, phone, cast, father_name, class, emergency_contact, sex, referred_from, document_path, hospital_id, d_type, bed_no, admission_date, status, profile_picture_path, national_id_no, d_department, total_expenses, outcome_summary, DOB) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sssssssssiissssssssss", $name, $fullAddress, $phone, $cast, $father_name, $class, $emergency_contact, $sex, $referred_from, $document_path, $hospital_id, $d_type, $bed_no, $admission_date, $status, $profilePicturePath, $national_id_no, $d_department, $total_expenses, $outcome_summary, $dob);

            if ($stmt->execute()) {
                echo "Patient data added successfully!";
                // Redirect after successful execution
                header("Location: hospital.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        
    }
    // if ($checkStmt->num_rows > 0 && $enabled){
    //         // Continue with your existing code to insert the data
    //         $sql_insert = "INSERT INTO patient (name, address, phone, cast, father_name, class, emergency_contact, sex, referred_from, document_path, hospital_id, d_type, bed_no, admission_date, status, profile_picture_path, national_id_no, d_department, total_expenses, outcome_summary, DOB) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    //         $stmt = $conn->prepare($sql_insert);
    //         $stmt->bind_param("sssssssssiissssssssss", $name, $fullAddress, $phone, $cast, $father_name, $class, $emergency_contact, $sex, $referred_from, $document_path, $hospital_id, $d_type, $bed_no, $admission_date, $status, $profilePicturePath, $national_id_no, $d_department, $total_expenses, $outcome_summary, $dob);

    //         if ($stmt->execute()) {
    //             echo "Patient data added successfully!";
    //             // Redirect after successful execution
    //             header("Location: hospital.php");
    //             exit();
    //         } else {
    //             echo "Error: " . $stmt->error;
    //         }

    //         $stmt->close();
    //         $checkStmt->close();
    // }
}



$conn->close();




?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient Data</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
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
    <nav>
        <ul>
            <li><a href="hospital.php">Home</a></li>

        </ul>
    </nav>
<br>
<br>
<div class="container">
    <h2><b>Add Patient Data</b></h2>

    <form method="post" action="" enctype="multipart/form-data">
        
        <label for="name">Name: </label>
        <input type="text" name="name" class="form-control" required>
            
       <label for="province">Province: </label>
<select name="province" id="province" class="form-control" onchange="populateDistricts()"></select>

<label for="district">District: </label>
<select name="district" id="district" class="form-control" onchange="populateMunicipalities()"></select>

<label for="municipality">Municipality: </label>
<select name="municipality" id="municipality" class="form-control"></select>

        <label for="address">Address: </label>
        <input type="text" name="address1" class="form-control">
        
        <label for="DOB">DOB: </label>
        <input type="date" name="dob" class="form-control" id="dob">
        
        <label for="sex">Sex: </label>
        <select name="sex" id="sex" class="form-control">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Others</option>
        </select>
        
        <label for="d_department" >Department of Disease: </label>
        <select name="d_department" id="d_department" class="form-control">
            <option value="family_medicine">Family Medicine</option>
            <option value="cardiology">Cardiology</option>
            <option value="gastroenterology/hepatology">Gastroenterology
/Hepatalogy</option>
            <option value="neurology">Neurology</option>
            <option value="oncology">Oncology</option>
            <option value="dermatology">Dermatology</option>
            <option value="emergency">Emergency</option>
            <option value="surgery">Surgery</option>
            <option value="gynaecology">Gynaecology</option>
            <option value="orthopedics">Orthopedics</option>
            <option value="dentistry">Dentistry</option>
            <option value="orthopedics">Orthopedics</option>
            <option value="ent">ENT</option>
            <option value="orthopedics">Orthopedics</option>
            <option value="pulmology">Pulmology</option>
            <option value="orthopedics">Orthopedics</option>
            <option value="urology">Urology</option>
            <option value="others">Others</option>
        </select>
        
        <label name="d_type">Disease Type: </label>
            <input type="text" name="d_type" class="form-control">
            
        <label for="cast" >Cast</label>
        <select name="cast" id="cast" class="form-control">
            <option value="brahmin/chhetri">Brahmin/Chetteri</option>
            <option value="dalit">Dalit</option>
            <option value="janjati">Janajati</option>
            <option value="madeshi">Madheshi</option>
            <option value="muslim">Muslim</option>
            <option value="others">Others</option>
        </select>
        <label for="phone">Phone: </label>
        <input type="text" name="phone" class="form-control">

        <label for="emergency_contact">Emergency Contact: </label>
        <input type="text" name="emergency_contact" class="form-control">

        <label for="referred_from">Referred From: </label>
        <input type="text" name="referred_from" class="form-control">

        <label for="father_name">
            Father's Name :
        </label>
        <input type="text" name="father_name" class="form-control">

        <label for="class">Class : </label>
        <select name="class" class="form-control" id="class">
            <option value="poor">Garib</option>
            <option value="helpless">Bipanna</option>
            <option value="aasahaya">Aasahaya</option>
        </select>


        <label for="profile_picture_path">Upload Profile Picture (Image):</label>
        <input type="file" name="profile_picture_path" accept=".jpg, .jpeg, .png" class="form-control">


        <label for="document">विपन्न परिचय पत्र/ वडा कार्यालय/ महानगरपालिकाको सिफारिस पत्र:</label>
        <input type="file" name="document" accept=".jpg, .jpeg, .png, .pdf" class="form-control" required>
        
                <label for="document">राष्ट्रिय परिचयपत्र / नेपाली नागरिकता प्रमाण पत्र/ जन्मदर्ता प्रमाणपत्र:</label>
        <input type="file" name="document" accept=".jpg, .jpeg, .png, .pdf" class="form-control" required>
        
        <label for="document">सर्जमिन गरिएको कागजात:</label>
        <input type="file" name="document" accept=".jpg, .jpeg, .png, .pdf" class="form-control" required>
        
                <label for="national_id_no">परिचयपत्र नम्बर</label>
        <input type="number" name="national_id_no" class="form-control" required>
        
        <label for="bed_no">Bed Number:</label>
        <input type="number" name="bed_no" class="form-control" required>

        <label for="admission_date">Admission Date:</label>
        <input type="date" name="admission_date" class="form-control" required>
        
        <label for="total_expenses">Total Expenses:</label>
        <input type="number" name="total_expenses" class="form-control" required>
        
        <label for="outcome_summary">Outcome Summary:</label>
        <input type="text" name="outcome_summary" class="form-control" required>

<input type="hidden" name="confirmed" value="1">


        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
        
    </form>
</div>
    <script src="address.js"></script>
    

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                /* Add this style to customize the button */
        

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