<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Section
if (isset($_POST['id'])) {
    $sectionId = $_POST['id'];

    // Perform the SQL query to delete the section by ID
    $deleteQuery = "DELETE FROM tbl_section WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $sectionId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "Section with ID $sectionId has been deleted.";
    } else {
        $errors['error'] = "Error deleting section.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>