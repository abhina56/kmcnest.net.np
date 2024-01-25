<?php
// Include the database connection file
include '../config.php';

// Retrieve parameters from the URL
$p_id = $_GET['p_id'] ?? 0;
$status = $_GET['status'] ?? '';

// Check if both parameters are provided
if ($p_id && $status) {
    // Sanitize input to prevent SQL injection
    $p_id = mysqli_real_escape_string($conn, $p_id);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status and set discharge date if status is "inactive"
    if ($status === 'inactive') {
        // Set discharge date as the current date
        $discharge_date = date('Y-m-d');

        // Update the status and discharge date in the database
        $sql_update_status = "UPDATE patient SET status = '$status', discharge_transfer_date = '$discharge_date' WHERE p_id = $p_id";
    } else {
        // Update only the status in other cases
        $sql_update_status = "UPDATE patient SET status = '$status' WHERE p_id = $p_id";
    }

    if ($conn->query($sql_update_status) === TRUE) {
        // Retrieve hospital ID from the patient details in the database
        $sql_select_hospital_id = "SELECT hospital_id FROM patient WHERE p_id = $p_id";
        $result_hospital_id = $conn->query($sql_select_hospital_id);

        if ($result_hospital_id->num_rows > 0) {
            $row_hospital_id = $result_hospital_id->fetch_assoc();
            $hospital_id = $row_hospital_id['hospital_id'];

            // Redirect to hospitaluser_p_view.php with hospital_id parameter
            header("Location: hospitaluser_p_view.php?hospital_id=$hospital_id");
            exit();
        } else {
            echo "Patient not found.";
        }
    } else {
        echo "Error updating status: " . $conn->error;
    }
} else {
    echo "Invalid parameters.";
}

// Close the database connection
$conn->close();
?>
