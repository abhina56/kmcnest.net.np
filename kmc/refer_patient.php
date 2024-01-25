<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $patientId = $_POST['patientId'] ?? null;
    $newHospitalId = $_POST['hospitalName'] ?? null;

    if ($patientId && $newHospitalId) {
        // Prepare SQL query to update hospital_id
        $sql_update_hospital = "UPDATE patient SET hospital_id = ? WHERE p_id = ?";
        $stmt = $conn->prepare($sql_update_hospital);
        $stmt->bind_param('ii', $newHospitalId, $patientId);

        // Execute and check if successful
        if ($stmt->execute()) {
            echo "Patient successfully referred to another hospital.";
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input data.";
    }

    $conn->close();

    // Redirect back to the patient view page or another appropriate page
    header('Location: view_patient_individual.php?p_id=' . $patientId);
    exit();
}
?>
<!-- Modal for Hospital Referral -->
<div class="modal" id="referModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Refer to Hospital</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="refer_patient.php" method="post">
                    <div class="form-group">
                        <label for="hospitalName">Select Hospital:</label>
                        <select class="form-control" id="hospitalName" name="hospitalName">
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
                    <input type="hidden" name="patientId" value="<?php echo $p_id; ?>"> <!-- Assuming $p_id is the patient's ID -->
                    <button type="submit" class="btn btn-primary">Refer</button>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
