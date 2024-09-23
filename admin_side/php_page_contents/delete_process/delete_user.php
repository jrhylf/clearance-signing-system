<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete Users
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Get department name assigned to the user
    $getDepartmentQuery = "SELECT department_assigned FROM tbl_users WHERE id = ?";
    $stmtGetDepartment = mysqli_prepare($db, $getDepartmentQuery);
    mysqli_stmt_bind_param($stmtGetDepartment, "i", $userId);
    mysqli_stmt_execute($stmtGetDepartment);
    $departmentResult = mysqli_stmt_get_result($stmtGetDepartment);

    if ($row = mysqli_fetch_assoc($departmentResult)) {
        $departmentAssigned = $row['department_assigned'];

        // Perform the SQL query to delete the user by ID
        $deleteQuery = "DELETE FROM tbl_users WHERE id = ?";
        $stmtDelete = mysqli_prepare($db, $deleteQuery);
        mysqli_stmt_bind_param($stmtDelete, "i", $userId);

        if (mysqli_stmt_execute($stmtDelete)) {
            // Update the 'user' column in 'tbl_departments' to "No User"
            $updateDepartmentQuery = "UPDATE tbl_departments SET user = 'No User' WHERE department_name = ?";
            $stmtUpdateDepartment = mysqli_prepare($db, $updateDepartmentQuery);
            mysqli_stmt_bind_param($stmtUpdateDepartment, "s", $departmentAssigned);

            if (mysqli_stmt_execute($stmtUpdateDepartment)) {
                $success['success'] = "User with ID $userId has been deleted, and 'user' column in 'tbl_departments' updated.";
            } else {
                $errors['error'] = "Error updating 'user' column in 'tbl_departments'.";
            }
        } else {
            $errors['error'] = "Error deleting user.";
        }
    } else {
        $errors['error'] = "Error fetching department_assigned for the user.";
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
