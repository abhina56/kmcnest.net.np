<?php
include '../config.php'; // Ensure this path is correct

if(isset($_POST['query'])){
    $query = $conn->real_escape_string($_POST['query']);
    $sql = "SELECT hospital_id, hospital_name FROM hospital WHERE hospital_name LIKE '%$query%'";

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        echo '<ul id="hospitalList">';
        while($row = $result->fetch_assoc()) {
            echo '<li data-value="'.$row['hospital_id'].'">'.$row['hospital_name'].'</li>';
        }
        echo '</ul>';
    }
}
?>
