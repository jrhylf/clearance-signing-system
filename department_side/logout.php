<?php 
	session_start();

	// Database connection
	include('conn.php');

	// Insert Audit Trail
	$current_date = date("Y-m-d");
	$current_time = date("H:i:s");
	$user = $_SESSION['user'];
	$department_name = $_SESSION['department'];
	$activity = "Logged out.";

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

	unset($_SESSION['Username']);
	header("Location:index.php");
?>