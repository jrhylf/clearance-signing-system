<?php
// Assuming you have a database connection
include('conn.php');

$id = $_POST['id'];
$department_name = $_POST['department_name'];
$applicable_course = $_POST['applicable_course'];
$user = $_POST['user'];

// Update the record in the database using prepared statement
$query = "UPDATE tbl_departments SET department_name = ?, applicable_course = ?, user = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "sssi", $department_name, $applicable_course, $user, $id);

// Execute the statement
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}

// Close the statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($db);
?>
