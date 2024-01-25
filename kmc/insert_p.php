<?php
include '../config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $emergency_contact = $_POST['emergency_contact'] ?? '';
    $referred_from = $_POST['referred_from'] ?? '';
    $sex = $_POST['sex'] ??'';
    $class = $_POST['class'] ??'';
    $father_name = $_POST['father_name'] ??'';
    $cast = $_POST['cast'] ?? '';
    $d_type = $_POST['d_type'] ?? 'Normal';
    $bed_no = $_POST['bed_no'] ?? '';
    $admission_date = $_POST['admission_date'] ?? '';
    $status = $_POST['status'] ?? 'Active';
    $profile_picture_path = $_POST['profile_picture_path'] ?? '';
    $hospital_id = $_SESSION['hospital_id'] ?? 0;  // Assuming hospital_id is stored in the session

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

if ($uploadOk == 1) {
    if ($uploadOk == 1) {
        $sql_insert = "INSERT INTO patient (name, address, phone, cast, father_name, class, emergency_contact, sex, referred_from, document_path, hospital_id, d_type, bed_no, admission_date, status, profile_picture_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("sssssssssiisssss", $name, $address, $phone, $cast, $father_name, $class, $emergency_contact, $sex, $referred_from, $document_path, $hospital_id, $d_type, $bed_no, $admission_date, $status, $profilePicturePath);

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
    $conn->close();
}
        header("Location: hospital.php");
    }

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
        
        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control" required>
            
       <label for="province">Province:</label>
<select name="province" id="province" class="form-control" onchange="populateDistricts()"></select>

<label for="district">District:</label>
<select name="district" id="district" class="form-control" onchange="populateMunicipalities()"></select>

<label for="municipality">Municipality:</label>
<select name="municipality" id="municipality" class="form-control"></select>

        <label for="address">Address:</label>
        <input type="text" name="address" class="form-control">
        
        <label for="DOB">DOB</label>
        <input type="date" class="form-control" id="dob">
        
        <label for="sex">Sex</label>
        <select name="sex" id="sex" class="form-control">
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Others</option>
        </select>
        
        <label name="d_type">Disease Type </label>
            <input type="text" name="d_type" class="form-control">
            
        <label for="cast" >Cast</label>
        <select name="cast" id="cast" class="form-control">
            <option value="">Brahmin/Chetteri</option>
            <option value="dalit">Dalit</option>
            <option value="janjati">Janajati</option>
            <option value="madeshi">Madheshi</option>
            <option value="muslim">Muslim</option>
            <option value="others">Others</option>
        </select>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" class="form-control">

        <label for="emergency_contact">Emergency Contact:</label>
        <input type="text" name="emergency_contact" class="form-control">

        <label for="referred_from">Referred From:</label>
        <select class="form-control" name="referred_from">
            <option value="स्पतालमा साेझै आएका बिरामी">अस्पतालमा साेझै आएका बिरामी</option>
            <option value="काठमाडाैँ महानगरबाट सिफारिस भएका बिरामी">काठमाडाैँ महानगरबाट सिफारिस भएका बिरामी</option>
            <option value="न्य स्थानिय तहबाट सिफारिस भएका बिरामी">अन्य स्थानिय तहबाट सिफारिस भएका बिरामी</option>
            <option value="आकस्मिक बिरामी">आकस्मिक बिरामी</option>

        </select>
        <label for="father_name">
            Father Name :
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
        
        <label for="bed_no">Bed Number:</label>
        <input type="number" name="bed_no" class="form-control" required>

        <label for="admission_date">Admission Date:</label>
        <input type="date" name="admission_date" class="form-control" required>

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
