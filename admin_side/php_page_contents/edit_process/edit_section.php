<?php
// Assuming you have a database connection
include('conn.php');

$id = $_POST['id'];
$course_code = $_POST['course_code'];
$section_number = $_POST['section_number'];

// Update the record in the database using prepared statement
$query = "UPDATE tbl_section SET course_code = ?, section_number = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssi", $course_code, $section_number, $id);

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
