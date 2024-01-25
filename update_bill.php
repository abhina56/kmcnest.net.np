<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientId = $_POST['patientId'];
    $totalCost = $_POST['totalCost'];
    $billDirs = [];

    // Handle multiple file uploads
    if (isset($_FILES['billFiles'])) {
        foreach ($_FILES['billFiles']['name'] as $key => $name) {
            if ($_FILES['billFiles']['error'][$key] == 0) {
                $fileName = time() . '_' . basename($name); // Create a unique file name
                $targetPath = 'upload_bill/' . $fileName;

                if (move_uploaded_file($_FILES['billFiles']['tmp_name'][$key], $targetPath)) {
                    // File upload successful, save the path
                    $billDirs[] = $targetPath;
                } else {
                    echo "Error uploading file: $name";
                    exit();
                }
            }
        }
    } else {
        echo "No files uploaded or error in files upload.";
        exit();
    }

    // Convert the array of paths to a string if needed
    // Example: implode them with a separator like comma
    $billDirsString = implode(',', $billDirs);

    // SQL to update bill details and bill directory
    $sql_update_bill = "UPDATE patient SET total = ?, bill_dir = ? WHERE p_id = ?";
    $stmt = $conn->prepare($sql_update_bill);
    $stmt->bind_param('isi', $totalCost, $billDirsString, $patientId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Bill and files updated successfully";
    } else {
        echo "Error updating bill";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the patient view page
    header('Location: view_patient_individual.php?p_id=' . $patientId);
    exit();
}
?>
