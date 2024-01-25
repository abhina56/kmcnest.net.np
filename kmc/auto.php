<?php
include '../config.php'; // Ensure this file contains your database connection

$term = mysqli_real_escape_string($dbConnection, $_GET['term']); // Fetch the term inputted in the autocomplete field

$query = "SELECT hospital_name FROM hospital WHERE hospital_name LIKE '%$term%'";
$result = mysqli_query($dbConnection, $query);

$hospitalNames = [];
while($row = mysqli_fetch_assoc($result)) {
    $hospitalNames[] = $row['hospital_name'];
}
echo json_encode($hospitalNames);
?>
