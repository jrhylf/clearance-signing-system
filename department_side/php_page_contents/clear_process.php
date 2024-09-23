<?php
session_start();
include('conn.php');

if (isset($_POST['id'])) {
    $studentId = $_POST['id'];

    // Update tbl_cleared
    $updateQuery = "UPDATE tbl_cleared SET status = 'OK', remarks = 'Cleared' WHERE student_id = '$studentId'";
    $result = mysqli_query($db, $updateQuery);
    
    // Set the timezone to Philippine Standard Time (UTC+8)
    date_default_timezone_set('Asia/Manila');
    // Insert Audit Trail
    $current_date = date("Y-m-d");
    $current_time = date("h:i:s A");
    $user = $_SESSION['user'];
    $department_name = $_SESSION['department'];
    $activity = "Cleared student " . $studentId . ".";
    
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

    if ($result) {
        $response = array('success' => true, 'message' => 'Row(s) cleared successfully');
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'message' => 'Error clearing student');
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'Invalid request');
    echo json_encode($response);
}
?>
