<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Course
if (isset($_POST['id'])) {
    $courseId = $_POST['id'];

    // Perform the SQL query to delete the course by ID
    $deleteQuery = "DELETE FROM tbl_courses WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $courseId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "Course with ID $courseId has been deleted.";
    } else {
        $errors['error'] = "Error deleting course.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>