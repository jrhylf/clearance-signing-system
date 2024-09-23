<?php
// Assuming you have a database connection
include('conn.php');

session_start();
$department = $_SESSION['department'];

// Check if the ID is set in the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // TODO: Perform a query to fetch data based on the provided ID
    $query = "SELECT * FROM tbl_cleared WHERE student_id = ? AND department = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ss", $id, $department);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // If a record is found, return it as JSON
        echo json_encode(array('success' => true, 'data' => $row));
    } else {
        // If no record is found, return an error
        echo json_encode(array('success' => false, 'error' => 'Record not found'));
    }

    mysqli_stmt_close($stmt);
} else {
    // If the ID is not set, return an error
    echo json_encode(array('success' => false, 'error' => 'ID not provided'));
}

mysqli_close($db);
?>
