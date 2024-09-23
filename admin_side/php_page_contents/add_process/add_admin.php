<?php 
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Add Administrator
if (isset($_POST['username'])) {
    // Get input and modify input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $position = $_POST['position'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $checkDuplicate = "SELECT * FROM tbl_administrator WHERE admin_username=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "s", $username);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);

    if ($duplicateCount > 0) {
        array_push($errors, "Administrator $username already exists in the database.");
    } else {
        // Add input to database
        $addToAdmin = "INSERT INTO tbl_administrator (admin_username, admin_pass, position, admin_firstname, admin_lastname, contact, email) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtAddToAdmin = mysqli_prepare($db, $addToAdmin);
        mysqli_stmt_bind_param($stmtAddToAdmin, "sssssss", $username, $hashed_password, $position, $firstname, $lastname, $contact, $email); // Use hashed password
        $addToAdminResult = mysqli_stmt_execute($stmtAddToAdmin);

        if ($addToAdminResult) {
            array_push($success, "Successfully added Administrator $username to Database.");
        } else {
            array_push($errors, "Error adding Administrator $username to the database.");
        }
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "errors" => $errors));
?>
