<?php
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$response = array('status' => 'error', 'message' => 'Error archiving records.');

// Transfer records from tbl_cleared to tbl_archived using prepared statement
$insertQuery = "INSERT INTO tbl_archived SELECT * FROM tbl_cleared";
$insertStatement = $db->prepare($insertQuery);
$insertSuccess = $insertStatement->execute();

if ($insertSuccess) {
    // Update tbl_archived and set the type to 'Archived' using prepared statement
    $updateQuery = "UPDATE tbl_archived SET type = 'Archived' ";
    $updateStatement = $db->prepare($updateQuery);
    $updateSuccess = $updateStatement->execute();
    $updateStatement->close(); // Close update statement
}

if ($updateSuccess) {
    // Delete records from tbl_cleared where type is 'Archived'
    $deleteQuery = "DELETE FROM tbl_cleared WHERE type = 'Active' OR type = 'Inactive' OR type = 'Alumni' OR type = 'Returnee' ";
    $deleteStatement = $db->prepare($deleteQuery);
    $deleteSuccess = $deleteStatement->execute();
    $deleteStatement->close(); // Close delete statement
}

$insertStatement->close(); // Close insert statement


// Insert Audit Trail
$current_date = date("Y-m-d");
$current_time = date("h:i:s A");
$user = $_SESSION['user'];
$department_name = $_SESSION['department'];
$activity = "Archived a student.";

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

// Check if the update, insert, and delete statements were successful
if ($insertSuccess && $updateSuccess && $deleteSuccess) {
    $response = array('status' => 'success', 'message' => 'Records archived successfully.');
} else {
    $response['message'] .= ' Insert: ' . $insertStatement->error . ' Update: ' . $updateStatement->error . ' Delete: ' . $deleteStatement->error;
}

// Close connection
$db->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
