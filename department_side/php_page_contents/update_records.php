<?php
include('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input
    $id = mysqli_real_escape_string($db, $_POST['student_id']);
    $department = mysqli_real_escape_string($db, $_SESSION['$department']);
    $reason = mysqli_real_escape_string($db, $_POST['reason']);

    // Update the record in the database
    $updateQuery = "UPDATE tbl_cleared SET remarks = '$reason' WHERE student_id = '$id' AND department = '$department' ";
    $updateResult = mysqli_query($db, $updateQuery);

    if ($updateResult) {
        // Set the timezone to Philippine Standard Time (UTC+8)
        date_default_timezone_set('Asia/Manila');
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

        echo "Record updated successfully.";
        // You may redirect the user or perform other actions after a successful update
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }
} else {
    echo "Invalid request method.";
}
?>