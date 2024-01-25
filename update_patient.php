<?php
include 'config.php';

// Retrieve POST data
$p_id = $_POST['p_id'] ?? 0;
$name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$sex = mysqli_real_escape_string($conn, $_POST['sex'] ?? '');
$cast = mysqli_real_escape_string($conn, $_POST['cast'] ?? '');
$DOB = mysqli_real_escape_string($conn, $_POST['DOB'] ?? '');
$address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
$phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
$emergency_contact = mysqli_real_escape_string($conn, $_POST['emergency_contact'] ?? '');
$father_name = mysqli_real_escape_string($conn, $_POST['father_name'] ?? '');
$class = mysqli_real_escape_string($conn, $_POST['class'] ?? '');
$d_type = mysqli_real_escape_string($conn, $_POST['d_type'] ?? '');
$refrred_from = mysqli_real_escape_string($conn, $_POST['referred_from'] ?? ''); // Corrected typo
$bed_no = mysqli_real_escape_string($conn, $_POST['bed_no'] ?? '');
$admission_date = mysqli_real_escape_string($conn, $_POST['admission_date'] ?? '');
$discharge_transfer_date = mysqli_real_escape_string($conn, $_POST['discharge_transfer_date'] ?? '');
$total = mysqli_real_escape_string($conn, $_POST['total'] ?? '');

// Prepare an UPDATE SQL query
$sql_update_patient = "UPDATE patient SET 
                       name = '$name', 
                       sex = '$sex', 
                       cast = '$cast', 
                       DOB = '$DOB', 
                       address = '$address', 
                       phone = '$phone', 
                       emergency_contact = '$emergency_contact', 
                       father_name = '$father_name', 
                       class = '$class', 
                       d_type = '$d_type', 
                       referred_from = '$refrred_from', 
                       bed_no = '$bed_no', 
                       admission_date = '$admission_date', 
                       discharge_transfer_date = '$discharge_transfer_date', 
                       total = '$total'
                       WHERE p_id = $p_id";

if ($conn->query($sql_update_patient) === TRUE) {
    // Redirect to the patient view page
    header('Location: view_patient_individual.php?p_id=' . $p_id);
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
