<?php
// Database connection
include('conn.php');

session_start();

// Variables
$success = array();
$errors = array();

// Add Students
if (isset($_POST['student_id'])) {
    // Get input and modify input
    $status = "OK";
    $studentId = $_POST['student_id'];
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $course = $_POST['course'];
    $section = $_POST['section'];
    $remarks = isset($_POST['remarks']) ? $_POST['remarks'] : 'Cleared'; // TODO: Insert the remarks only on whose Department is logged in.
    $department = "Registrar"; // Set the department to "Registrar"
    $type = $_POST['type']; // Active, Inactive, Alumni, Returnee
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // TODO: Get the sy_start-sy_end and semester from tbl_sy_sem WHERE status = 'Active'
    $sy_start = "SELECT sy_start FROM tbl_sy_sem WHERE status = 'Active'";
    $sy_end = "SELECT sy_end FROM tbl_sy_sem WHERE status = 'Active'";
    $semester = "SELECT semester FROM tbl_sy_sem WHERE status = 'Active'";
    $sy_start_result = mysqli_query($db, $sy_start);
    $sy_end_result = mysqli_query($db, $sy_end);
    $semester_result = mysqli_query($db, $semester);
    $sy_start_row = mysqli_fetch_array($sy_start_result);
    $sy_end_row = mysqli_fetch_array($sy_end_result);
    $semester_row = mysqli_fetch_array($semester_result);
    $sy_start = $sy_start_row['sy_start'];
    $sy_end = $sy_end_row['sy_end'];

    $school_year = $sy_start . "-" . $sy_end;
    $semester = $semester_row['semester'];

    // Add input to database
    $addToStudents = "INSERT INTO tbl_cleared (status, student_id, last_name, first_name, course_code, section, remarks, department, type, email, password, school_year, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtAddToStudents = mysqli_prepare($db, $addToStudents);
    mysqli_stmt_bind_param($stmtAddToStudents, "sssssssssssss", $status, $studentId, $lastname, $firstname, $course, $section, $remarks, $department, $type, $email, $hashed_password, $school_year, $semester);
    $addToStudentsResult = mysqli_stmt_execute($stmtAddToStudents);

    if ($addToStudentsResult) {
        array_push($success, "Successfully added $studentId $firstname $lastname to Database with department $department.");
    } else {
        array_push($errors, "Error adding Student $studentId to the database with department $department: " . mysqli_error($db));
    }
    // Close the database connection
    mysqli_close($db);
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
