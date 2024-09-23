<?php
session_start();
// Database connection
include('conn.php');

// Variables
$response = array(); // Initialize the $response array

// Delete Announcements
if (isset($_POST['id'])) {
    $announcementId = $_POST['id'];

    // Perform the SQL query to delete the announcement by ID
    $deleteQuery = "DELETE FROM tbl_announcements WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $announcementId);

    if (mysqli_stmt_execute($stmtDelete)) {
        // Insert Audit Trail for deleting an announcement
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Deleted an Announcement.";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
        $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

        // Execute the statement and check for errors
        if (!$addToActivityResult) {
            $response['status'] = 'error';
            $response['message'] = 'Error inserting audit trail: ' . mysqli_error($db);
        } else {
            $response['status'] = 'success';
            $response['message'] = "Deleted an Announcement.";
        }

        // Close the statement
        mysqli_stmt_close($stmtAddToActivity);
        // Audit Trail end
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error deleting announcement: ' . mysqli_error($db);
    }
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
