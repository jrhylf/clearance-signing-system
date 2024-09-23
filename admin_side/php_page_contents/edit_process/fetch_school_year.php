<?php
// Assuming you have a database connection
include('conn.php');

// Check if 'id' is set in the POST data
if (isset($_POST['id'])) {
    // Use mysqli_real_escape_string to sanitize input
    $sectionId = mysqli_real_escape_string($db, $_POST['id']);

    // Use a prepared statement to prevent SQL injection
    $query = "SELECT * FROM tbl_sy_sem WHERE id = ?";

    $stmt = mysqli_prepare($db, $query);

    // Bind the parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $sectionId);

    // Execute the query
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Get the result set
        $resultSet = mysqli_stmt_get_result($stmt);

        // Fetch the record as an associative array
        $record = mysqli_fetch_assoc($resultSet);

        // Return the result as JSON
        echo json_encode(array('success' => true, 'data' => $record));
    } else {
        // Return failure if the query fails
        echo json_encode(array('success' => false));
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($db);
?>
