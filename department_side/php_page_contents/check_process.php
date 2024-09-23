<?php
include('conn.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate and sanitize the input
$id = $_POST['id'];

if ($id !== null) {
    // TODO: Use $id as needed in your PHP logic
    // For example, fetch data from the database based on the ID
    // TODO: Fetch data from tbl_cleared based on the ID

    if ($db === false) {
        echo json_encode(['error' => 'Database connection error']);
        exit;
    }

    $department = 'registrar';

    if ($department !== null) {
        $query = "SELECT student_id, last_name, first_name, course_code, section FROM tbl_cleared WHERE student_id = ? AND remarks = 'Cleared' AND department = ?";
        $stmt = mysqli_prepare($db, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $id, $department);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            // Check for query success
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo json_encode(['success' => true, 'data' => $row]);
            } else {
                echo json_encode(['error' => 'Error fetching data: ' . mysqli_error($db)]);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['error' => 'Error preparing statement']);
        }
    } else {
        echo json_encode(['error' => 'Invalid session data']);
    }
} else {
    echo json_encode(['error' => 'Invalid input']);
}

?>