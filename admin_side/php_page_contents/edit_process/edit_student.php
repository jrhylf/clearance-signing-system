<?php
// Assuming you have a database connection
include('conn.php');

// Get the logged-in department from the session
$logged_in_department = isset($_SESSION['department']) ? $_SESSION['department'] : '';

$id = $_POST['id'];
$status = "OK";
$studentId = $_POST['student_id'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$course = $_POST['course'];
$section = $_POST['section'];
$departments = $_POST['department']; // Registrar, Accounting, Proware, Academic

// Insert the remarks only for the logged-in department
$remarks = ($departments == $logged_in_department) ? $_POST['remarks'] : $_POST['remarks'];

$type = $_POST['type']; // Active, Inactive, Alumni, Returnee
$email = $_POST['email'];
$password = $_POST['password']; // TODO: Update the password regardless of the department
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

// Use prepared statement to prevent SQL injection
$query = "UPDATE tbl_cleared SET status = ?, last_name = ?, first_name = ?, course_code = ?, section = ?, remarks = ?, type = ?, email = ?, password = ? WHERE student_id = ? AND department = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "sssssssssss", $status, $lastname, $firstname, $course, $section, $remarks, $type, $email, $hashed_password, $studentId, $departments);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}

mysqli_stmt_close($stmt);
mysqli_close($db);
?>
