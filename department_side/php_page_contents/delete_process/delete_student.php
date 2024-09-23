<?php
session_start();
// Database connection
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

// Variables
$response = array();

// Archive Student
if (isset($_POST['id'])) {
    $studentId = $_POST['id'];

    // Transfer records from tbl_cleared to tbl_archived using prepared statement
    $insertQuery = "INSERT INTO tbl_archived SELECT * FROM tbl_cleared WHERE id = ?";
    $insertStatement = mysqli_prepare($db, $insertQuery);
    mysqli_stmt_bind_param($insertStatement, "i", $studentId);

    // Perform the SQL query to delete the student by ID using a prepared statement
    $deleteQuery = "DELETE FROM tbl_cleared WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $studentId);

    // Execute the archive statement
    if (mysqli_stmt_execute($insertStatement)) {
        // Insert Audit Trail for Archiving
        $current_date = date("Y-m-d");
        $current_time = date("h:i:s A");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Archived student " . $studentId . ".";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);

        // Check if the audit trail statement was successful
        if (mysqli_stmt_execute($stmtAddToActivity)) {
            // Execute the delete statement
            if (mysqli_stmt_execute($stmtDelete)) {
                $response['status'] = 'success';
                $response['message'] = "Student with ID $studentId has been archived. Audit trail inserted successfully.";
            } else {
                $response['status'] = 'error';
                $response['message'] = "Error deleting student: " . mysqli_error($db);
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = "Error archiving student (Audit Trail): " . mysqli_error($db);
        }

        // Close the statements
        mysqli_stmt_close($stmtAddToActivity);
        mysqli_stmt_close($insertStatement);
        mysqli_stmt_close($stmtDelete);
    } else {
        $response['status'] = 'error';
        $response['message'] = "Error archiving student: " . mysqli_error($db);
    }
}

// Return response as JSON
echo json_encode($response);
?>
