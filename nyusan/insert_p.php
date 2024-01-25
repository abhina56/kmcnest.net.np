<?php
include 'config.php';
session_start();


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data with checks for existence
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $emergency_contact = $_POST['emergency_contact'] ?? '';
    $p_type = $_POST['p_type'] ?? '';
    $referred_from = $_POST['referred_from'] ?? '';
    $hospital_id = $_SESSION['hospital_id'] ?? '';


    // Process file upload
    $uploadDirectory = 'uploads/';  // Create a folder named 'uploads' in your root directory
    $targetFile = $uploadDirectory . basename($_FILES["document"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a valid image or PDF
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["document"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image or PDF - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image or PDF.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        $path_parts = pathinfo($targetFile);
        $filename = $path_parts['filename'];
        $extension = $path_parts['extension'];

        // Generate a random unique filename
        $newFilename = uniqid() . '_' . $filename . '.' . $extension;

        // Construct the new target file path
        $newTargetFile = $uploadDirectory . $newFilename;

        // Check if the new target file already exists (unlikely, but to be thorough)
        while (file_exists($newTargetFile)) {
            $newFilename = uniqid() . '_' . $filename . '.' . $extension;
            $newTargetFile = $uploadDirectory . $newFilename;
        }

        // Move the uploaded file with the new filename
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $newTargetFile)) {
            echo "The file " . htmlspecialchars(basename($newFilename)) . " has been uploaded with a random name.";
            $document_path = $newTargetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    } else {
        // File does not exist, proceed with the original filename
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["document"]["name"])) . " has been uploaded.";
            $document_path = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    }

    // Check file size (you can adjust the size limit)
    if ($_FILES["document"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "pdf") {
        echo "Sorry, only JPG, JPEG, PNG, & PDF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Move uploaded file and provide user feedback
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["document"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Continue with other form data only if file upload was successful
    if ($uploadOk == 1) {
        $document_path = $targetFile;
        $hospital_id = $_POST['hospital_id'] ?? ''; // Retrieve hospital_id from the form
        $bed_no = $_POST['bed_no'] ?? '';
        $admission_date = $_POST['admission_date'] ?? '';
        // Set the default value for status to 'Active'
        $status = $_POST['status'] ?? 'Active';

        // Insert data into the patient table
        $sql_insert = "INSERT INTO patient (name, address, phone, emergency_contact,p_type, referred_from, document_path, hospital_id, bed_no, admission_date, status)
                       VALUES ('$name', '$address', '$phone', '$emergency_contact', '$p_type', '$referred_from', '$document_path', $hospital_id, $bed_no, '$admission_date','$status')";

        // Execute the SQL query
        if ($conn->query($sql_insert) === TRUE) {
            echo "Patient data added successfully!";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }

        header("Location: view_p.php");

        // Close the database connection
        $conn->close();
    }
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
        body {
            background-color: #f8f9fa;
            margin: 50px;
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

<div class="container">
    <h2>Add Patient Data</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" class="form-control" required>

        <label for="address">Address:</label>
        <input type="text" name="address" class="form-control">

        <label for="phone">Phone:</label>
        <input type="text" name="phone" class="form-control">

        <label for="emergency_contact">Emergency Contact:</label>
        <input type="text" name="emergency_contact" class="form-control">

        <label for="referred_from">Referred From:</label>
        <input type="text" name="referred_from" class="form-control">

        <label for="document">Upload Document (Image or PDF):</label>
        <input type="file" name="document" accept=".jpg, .jpeg, .png, .pdf" class="form-control" required>
        
        <label for="bed_no">Bed Number:</label>
        <input type="number" name="bed_no" class="form-control" required>

        <label for="admission_date">Admission Date:</label>
        <input type="date" name="admission_date" class="form-control" required>

        <input type="submit" name="submit" class="btn btn-primary" value="Submit">
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
