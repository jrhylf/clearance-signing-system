<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Department
if (isset($_POST['id'])) {
    $departmentId = $_POST['id'];

    // Perform the SQL query to delete the department by ID
    $deleteQuery = "DELETE FROM tbl_departments WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $departmentId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "Department with ID $departmentId has been deleted.";
    } else {
        $errors['error'] = "Error deleting department.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>