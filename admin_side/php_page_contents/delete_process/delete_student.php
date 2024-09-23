<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Student
if (isset($_POST['id'])) {
    $studentId = $_POST['id'];

    // Perform the SQL query to delete the student by ID using prepared statement
    $deleteQuery = "DELETE FROM tbl_cleared WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $studentId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "Student with ID $studentId has been deleted.";
    } else {
        $errors['error'] = "Error deleting Student.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
