<?php
session_start();
// Assuming you have a database connection
include('conn.php');

// Validate existence of POST variables
if (isset($_POST['id'], $_POST['sy_start'], $_POST['sy_end'], $_POST['semester'], $_POST['status'])) {
    $id = $_POST['id'];
    $sy_start = $_POST['sy_start'];
    $sy_end = $_POST['sy_end'];
    $semester = $_POST['semester'];
    $status = $_POST['status'];

    // Check if there is a duplicate entry for sy_start, sy_end, and semester
    $duplicate_query = "SELECT COUNT(*) FROM tbl_sy_sem WHERE sy_start = ? AND sy_end = ? AND semester = ?";
    $stmt_duplicate = mysqli_prepare($db, $duplicate_query);
    mysqli_stmt_bind_param($stmt_duplicate, "sss", $sy_start, $sy_end, $semester);
    mysqli_stmt_execute($stmt_duplicate);
    mysqli_stmt_bind_result($stmt_duplicate, $count);
    mysqli_stmt_fetch($stmt_duplicate);
    mysqli_stmt_close($stmt_duplicate);

    if ($count > 0) {
        $response = ['success' => false, 'message' => 'Duplicate entry for start year, end year, and semester.'];
    } else {
        // Update the record in the database using prepared statement
        $query = "UPDATE tbl_sy_sem SET sy_start = ?, sy_end = ?, semester = ?, status = ? WHERE id = ?";
        $stmt = mysqli_prepare($db, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssi", $sy_start, $sy_end, $semester, $status, $id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Insert Audit Trail for updating a school year and semester record
            $current_date = date("Y-m-d");
            $current_time = date("H:i:s");
            $user = $_SESSION['user'];
            $department_name = $_SESSION['department'];
            $activity = "Updated a School Year and Semester.";

            $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
            $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
            mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
            $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

            // Execute the statement and check for errors
            if (!$addToActivityResult) {
                $response = ['success' => false, 'message' => 'Error inserting audit trail: ' . mysqli_error($db)];
            } else {
                $response = ['success' => true];
            }

            // Close the statement
            mysqli_stmt_close($stmtAddToActivity);
        } else {
            $response = ['success' => false, 'message' => 'Error updating school year and semester record: ' . mysqli_error($db)];
        }

        // Close the statement and the database connection
        mysqli_stmt_close($stmt);
        mysqli_close($db);
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid or missing POST data.'];
}

// Send the JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
