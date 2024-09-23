<?php
session_start();
include('conn.php');

// Insert Audit Trail
$current_date = date("Y-m-d");
$current_time = date("H:i:s");
$user = $_SESSION['user'];
$department_name = $_SESSION['department'];
$activity = "Exported all records";

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

// Close the MySQL connection
$db->close();

header("location: /department_side/login_using_msO365/export_all.php");