<?php
session_start();
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Delete School Year
if (isset($_POST['id'])) {
    $schoolYearId = $_POST['id'];

    // Perform the SQL query to delete the school year by ID
    $deleteQuery = "DELETE FROM tbl_sy_sem WHERE id = ?";
    $stmtDelete = mysqli_prepare($db, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i", $schoolYearId);

    if (mysqli_stmt_execute($stmtDelete)) {
        $success['success'] = "School Year with ID $schoolYearId has been deleted.";

        // Insert Audit Trail for deleting a school year
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Deleted a school year.";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
        $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

        // Execute the statement and check for errors
        if (!$addToActivityResult) {
            $errors['error'] = "Error inserting audit trail: " . mysqli_error($db);
        }

        // Close the statement
        mysqli_stmt_close($stmtAddToActivity);
    } else {
        $errors['error'] = "Error deleting school year: " . mysqli_error($db);
    }
}

// Close the database connection
mysqli_stmt_close($stmtDelete);
mysqli_close($db);

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
