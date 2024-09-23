<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Add User
if (isset($_POST['username'])) {
    // Collect and sanitize user input as needed
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $gender = $_POST['gender'];
    $departmentAssigned = $_POST['department_assigned'];
    $position = $_POST['position'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $checkDuplicate = "SELECT * FROM tbl_users WHERE user_username=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "s", $username);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);

    if ($duplicateCount > 0) {
        $errors['error'] = "User $firstname $lastname already exists in the database."; // TODO: This should throw an error in the modal in AJAX.
    } else {
        if (empty($middlename) || empty($contact)) {
            $middlename = "N/A";
            $contact = 0;
        }
        // Add input to the database
        $addToUsers = "INSERT INTO tbl_users (last_name, first_name, middle_name, gender, department_assigned, position, user_username, user_password, email, contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAddToUsers = mysqli_prepare($db, $addToUsers);
        mysqli_stmt_bind_param($stmtAddToUsers, "ssssssssss", $lastname, $firstname, $middlename, $gender, $departmentAssigned, $position, $username, $hashed_password, $email, $contact); // Use hashed password
        $addToUsersResult = mysqli_stmt_execute($stmtAddToUsers);

        if ($addToUsersResult) {
            echo "Nice";
        } else {
            echo "console.log('Error adding the user to tbl_users');";
        }        
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
