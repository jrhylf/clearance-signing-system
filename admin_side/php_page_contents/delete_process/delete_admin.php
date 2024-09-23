<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Admin
if (isset($_POST['id'])) {
    $adminId = $_POST['id'];

    // Perform the SQL query to delete the admin by ID
    $deleteQuery = "DELETE FROM tbl_administrator WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $adminId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "Admin with ID $adminId has been deleted.";
    } else {
        $errors['error'] = "Error deleting admin.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>