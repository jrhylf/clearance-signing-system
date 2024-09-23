<?php
// Assuming you have a database connection
include('conn.php');

$id = $_POST['id'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$position = $_POST['position'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Use prepared statement to prevent SQL injection
$query = "UPDATE tbl_administrator SET admin_username = ?, admin_pass = ?, position = ?, admin_firstname = ?, admin_lastname = ?, contact = ?, email = ?, position = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "ssssssssi", $username, $hashed_password, $position, $firstname, $lastname, $contact, $email, $position, $id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}

mysqli_stmt_close($stmt);
mysqli_close($db);
?>
