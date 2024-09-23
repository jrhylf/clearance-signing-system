<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Add Department
if (isset($_POST['department_name'])) {
    $departmentName = $_POST['department_name'];
    $assignedUser = "No User";
    $applicableCourse = $_POST['applicable_course'];

    // Check for duplicate department
    $checkDuplicate = "SELECT department_name FROM tbl_departments WHERE department_name=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "s", $departmentName);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);

    if ($duplicateCount > 0) {
        $errors[] = "Department $departmentName already exists in the database.";
    } else {
        // Add department to the database
        $addToDepartments = "INSERT INTO tbl_departments (department_name, user, applicable_course) VALUES (?, ?, ?)";
        $stmtAddToDepartments = mysqli_prepare($db, $addToDepartments);
        mysqli_stmt_bind_param($stmtAddToDepartments, "sss", $departmentName, $assignedUser, $applicableCourse);
        $addToDepartmentsResult = mysqli_stmt_execute($stmtAddToDepartments);

        if ($addToDepartmentsResult) {
            $success[] = "Successfully added $departmentName to Database.";
        } else {
            $errors[] = "Error adding department to the database.";
        }
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
