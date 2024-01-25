<?php
include 'config.php'; // Include your database configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $hospital_id = $conn->real_escape_string($_POST['hospital_id']); // Assuming you have a hidden input for hospital_id
    $hospital_name = $conn->real_escape_string($_POST['hospital_name']);
    $total_bed = $conn->real_escape_string($_POST['total_bed']);
    $hospital_type = $conn->real_escape_string($_POST['hospital_type']);
    $contact_person = $conn->real_escape_string($_POST['contact_person']);
    $contact_email = $conn->real_escape_string($_POST['contact_email']);
    $contact_number = $conn->real_escape_string($_POST['contact_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $hashedPassword = $conn->real_escape_string($_POST['hashedPassword']); // Be cautious about updating passwords

    // Update query
    $sql = "UPDATE hospital SET 
                hospital_name = '$hospital_name',
                total_bed = '$total_bed',
                hospital_type = '$hospital_type',
                contact_person = '$contact_person',
                contact_email = '$contact_email',
                contact_number = '$contact_number',
                address = '$address',
                hashedPassword = '$hashedPassword'
            WHERE hospital_id = '$hospital_id'";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
 header('Location: profile.php');
} else {
        echo "Error updating record: " . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
