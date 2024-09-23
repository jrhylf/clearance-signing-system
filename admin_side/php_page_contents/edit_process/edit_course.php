<?php
// Assuming you have a database connection
include('conn.php');

$id = $_POST['id'];
$course_code = $_POST['course_code'];
$course_desc = $_POST['course'];

// Update the record in the database using prepared statement
$query = "UPDATE tbl_courses SET course_code = ?, course_description = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssi", $course_code, $course_desc, $id);

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
