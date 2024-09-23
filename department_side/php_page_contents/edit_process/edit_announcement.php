<?php
session_start();

// Assuming you have a database connection
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

$id = $_POST['id'];
$titleAnnouncement = $_POST['title'];
$descriptionAnnouncement = $_POST['description'];
$announceFor = $_POST['announce_for'];
$startDate = $_POST['start_date'];
$startTime = $_POST['start_time'];
$endDate = $_POST['end_date'];
$endTime = $_POST['end_time'];
$image = $_POST['image'];

// Update the record in the database using a prepared statement
$query = "UPDATE tbl_announcements SET title = ?, description = ?, announce_for = ?, start_date = ?, start_time = ?, end_date = ?, end_time = ?, image = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssssssssi", $titleAnnouncement, $descriptionAnnouncement, $announceFor, $startDate, $startTime, $endDate, $endTime, $image, $id);

// Execute the statement and handle the result directly in the if condition
if (mysqli_stmt_execute($stmt)) {
    // Insert Audit Trail for updating an announcement
    $current_date = date("Y-m-d");
    $current_time = date("h:i:s A");
    $user = $_SESSION['user'];
    $department_name = $_SESSION['department'];
    $activity = "Updated Announcement {$titleAnnouncement}.";

    $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
    $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
    mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
    
    // Execute the statement directly in the if condition
    if (mysqli_stmt_execute($stmtAddToActivity)) {
        $response = ['status' => 'success', 'message' => 'Announcement updated successfully.'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error updating announcement: ' . mysqli_error($db)];
    }

    // Close the statement
    mysqli_stmt_close($stmtAddToActivity);
} else {
    $response = ['status' => 'error', 'message' => 'Error updating announcement: ' . mysqli_error($db)];
}

// Close the statement and the database connection
mysqli_stmt_close($stmt);
mysqli_close($db);

// Return the JSON response
echo json_encode($response);
?>
