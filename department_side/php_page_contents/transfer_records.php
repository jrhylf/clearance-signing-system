<?php
include('conn.php');

session_start();
$department = $_SESSION['department'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sourceTable = $_POST['source_table'];
    $transferAction = $_POST['transfer_action'];

    if ($transferAction == 'hold_student') {
        // First, update the remarks column in tbl_cleared
        // SELECT student_id FROM tbl_cleared
        $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
        $reason = mysqli_real_escape_string($db, $_POST['reason']);
        mysqli_query($db, "UPDATE tbl_cleared SET remarks = '$reason' WHERE student_id = '$student_id' AND department = '$department' ");

        // Set the timezone to Philippine Standard Time (UTC+8)
        date_default_timezone_set('Asia/Manila');
        // Insert Audit Trail
        $current_date = date("Y-m-d");
        $current_time = date("h:i:s A");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Held student " . $student_id . ".";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
        $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

        // Execute the statement and check for errors
        if ($addToActivityResult) {
            echo "Audit trail inserted successfully.";
        } else {
            echo "Error: " . mysqli_error($db);
        }

        // Close the statement
        mysqli_stmt_close($stmtAddToActivity);
        // Insert Audit Trail End

        // Reload the page
        echo '<script>window.location.href = "/department_side/mainPage.php?page=clearance";</script>';
        exit;
    } else if ($transferAction == 'clear_student') {
        // First, update the reason column in tbl_hold
        $student_id = mysqli_real_escape_string($db, $_POST['student_id']);
        mysqli_query($db, "UPDATE tbl_cleared SET status = 'OK' AND  remarks = 'Cleared' WHERE student_id = '$student_id' AND department = '$department'");

        // Insert Audit Trail
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Cleared student " . $student_id . ".";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
        $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

        // Execute the statement and check for errors
        if ($addToActivityResult) {
            echo "Audit trail inserted successfully.";
        } else {
            echo "Error: " . mysqli_error($db);
        }

        // Close the statement
        mysqli_stmt_close($stmtAddToActivity);
        // Insert Audit Trail End

        // Reload the page
        echo '<script>window.location.href = "/department_side/mainPage.php?page=clearance";</script>';
        exit;
    }
} else {
    // Handle invalid request
    http_response_code(400);
    exit;
}
?>