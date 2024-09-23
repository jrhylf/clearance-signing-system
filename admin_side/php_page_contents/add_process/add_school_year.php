<?php
session_start();
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $semester = $_POST['semester'];
    $status = $_POST['status'];

    // Check if there is a duplicate entry for start_year, end_year, and semester
    $duplicate_query = "SELECT COUNT(*) FROM tbl_sy_sem WHERE sy_start = ? AND sy_end = ? AND semester = ?";
    $stmt_duplicate = mysqli_prepare($db, $duplicate_query);
    mysqli_stmt_bind_param($stmt_duplicate, "sss", $start_year, $end_year, $semester);
    mysqli_stmt_execute($stmt_duplicate);
    mysqli_stmt_bind_result($stmt_duplicate, $count);
    mysqli_stmt_fetch($stmt_duplicate);
    mysqli_stmt_close($stmt_duplicate);

    if ($count > 0) {
        $response = ['status' => 'error', 'message' => 'Duplicate entry for start year, end year, and semester.'];
    } else {
        // Update the records in tbl_sy_sem to have status = Inactive if $_POST['status'] == 'Active'
        if ($status == 'Active') {
            $update_query = "UPDATE tbl_sy_sem SET status = 'Inactive'";
            mysqli_query($db, $update_query);
            // $updateSySem = 
            //if ($updateSySem) {
            //     // TODO: call the archive.php script here
            //     $insertQuery = "INSERT INTO tbl_archived SELECT * FROM tbl_cleared";
            //     $insertStatement = $db->prepare($insertQuery);
            //     $insertSuccess = $insertStatement->execute();

            //     if ($insertSuccess) {
            //         // Update tbl_archived and set the type to 'Archived' using prepared statement
            //         $updateQuery = "UPDATE tbl_archived SET type = 'Archived' ";
            //         $updateStatement = $db->prepare($updateQuery);
            //         $updateSuccess = $updateStatement->execute();
            //         $updateStatement->close(); // Close update statement
            //     }

            //     if ($updateSuccess) {
            //         // Delete records from tbl_cleared where type is 'Archived'
            //         $deleteQuery = "DELETE FROM tbl_cleared WHERE type = 'Active'";
            //         $deleteStatement = $db->prepare($deleteQuery);
            //         $deleteSuccess = $deleteStatement->execute();
            //         $deleteStatement->close(); // Close delete statement
            //     }

            //     $insertStatement->close(); // Close insert statement

            //     // Check if the update, insert, and delete statements were successful
            //     if ($insertSuccess && $updateSuccess && $deleteSuccess) {
            //         $response = array('status' => 'success', 'message' => 'Records archived successfully.');
            //     } else {
            //         $response['message'] .= ' Insert: ' . $insertStatement->error . ' Update: ' . $updateStatement->error . ' Delete: ' . $deleteStatement->error;
            //     }
            // }
        }

        // Perform database operation (inserting data into tbl_sy_sem)
        $insert_query = "INSERT INTO tbl_sy_sem (sy_start, sy_end, semester, status) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $insert_query);

        if ($stmt) {
            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt, "ssss", $start_year, $end_year, $semester, $status);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                // Insert successful

                // Insert Audit Trail for adding a new school year and semester
                $current_date = date("Y-m-d");
                $current_time = date("H:i:s");
                $user = $_SESSION['user'];
                $department_name = $_SESSION['department'];
                $activity = "Added a new school year and semester ({$start_year}-{$end_year}, Semester {$semester}).";

                $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
                $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
                mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
                $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

                // Execute the statement and check for errors
                if ($addToActivityResult) {
                    $response = ['status' => 'success', 'message' => 'School year and semester added successfully.'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Error inserting audit trail: ' . mysqli_error($db)];
                }

                // Close the statement
                mysqli_stmt_close($stmtAddToActivity);
                // Audit Trail end
            } else {
                // Insert failed
                $response = ['status' => 'error', 'message' => 'Error inserting data into tbl_sy_sem: ' . mysqli_error($db)];
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Statement preparation failed
            $response = ['status' => 'error', 'message' => 'Error preparing the SQL statement: ' . mysqli_error($db)];
        }
    }

    // Close the database connection
    mysqli_close($db);

    // Send the JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If the script is not accessed through a POST request, return an error response
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
    header('Location: /CAPSTONE_CSS/department_side/mainPage.php?page=php_mntc_academic');
    echo json_encode($response);
}
?>
