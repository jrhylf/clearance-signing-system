<?php
session_start();

// Assuming you have a database connection
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

// Get the logged-in department from the session
$logged_in_department = isset($_SESSION['department']) ? $_SESSION['department'] : '';

// Extract values from POST data
$id = $_POST['id'];
$studentId = $_POST['student_id'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$course = $_POST['course'];
$section = $_POST['section'];
$departments = $_POST['department']; // Registrar, Accounting, Proware, Academic

// Insert the remarks only for the logged-in department
$remarks = ($departments == $logged_in_department) ? $_POST['remarks'] : $_POST['remarks'];

// Set status based on remarks
$status = ($remarks == 'Cleared') ? 'OK' : 'On-Hold';

// Extract other values from POST data
$type = $_POST['type']; // Active, Inactive, Alumni, Returnee
$email = $_POST['email'];
$password = $_POST['password']; // TODO: Update the password regardless of the department
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
$schoolYear = $_POST['schoolYear'];
$semester = $_POST['semester'];

// Use prepared statement to prevent SQL injection
$query = "UPDATE tbl_cleared SET status = ?, last_name = ?, first_name = ?, course_code = ?, section = ?, remarks = ?, type = ?, email = ?, password = ?, school_year = ?, semester = ? WHERE student_id = ? AND department = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "sssssssssssss", $status, $lastname, $firstname, $course, $section, $remarks, $type, $email, $hashed_password, $schoolYear, $semester, $studentId, $departments);
$result = mysqli_stmt_execute($stmt);

// Return response as JSON
if ($result) {
    // Insert Audit Trail
    $current_date = date("Y-m-d");
    $current_time = date("h:i:s A");
    $user = $_SESSION['user'];
    $department_name = $_SESSION['department'];
    $activity = "Updated student " . $studentId . ".";

    $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
    $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
    mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
    $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

    // Execute the statement and check for errors
    if ($addToActivityResult) {
        echo json_encode(array('success' => true, 'message' => 'Audit trail inserted successfully.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error inserting audit trail: ' . mysqli_error($db)));
    }

    // Close the statement
    mysqli_stmt_close($stmtAddToActivity);
} else {
    echo json_encode(array('success' => false, 'message' => 'Error updating student: ' . mysqli_error($db)));
}

// Close the database connection
mysqli_stmt_close($stmt);
mysqli_close($db);
?>
