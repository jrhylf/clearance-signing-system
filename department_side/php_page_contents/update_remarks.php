<?php
include('conn.php');

session_start();

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the student_id and department from the AJAX request
    $studentId = $_POST['student_id'];
    $department = $_SESSION['department'];

    // Check if the student's remarks are already Cleared
    $checkSql = "SELECT remarks FROM tbl_cleared WHERE student_id = ? AND department = ?";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bind_param("ss", $studentId, $department);
    $checkStmt->execute();
    $checkStmt->bind_result($currentRemarks);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($currentRemarks !== "Cleared") {
        // Update the remarks in tbl_cleared using prepared statement
        $updateSql = "UPDATE tbl_cleared SET remarks = 'Cleared' WHERE student_id = ? AND department = ?";
        $updateStmt = $db->prepare($updateSql);
        $updateStmt->bind_param("ss", $studentId, $department);

        if ($updateStmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Cleared Successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to Clear student."));
        }

        $updateStmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Already Cleared!"));
    }
} else {
    // Handle invalid request
    http_response_code(400);
}

$db->close();
?>