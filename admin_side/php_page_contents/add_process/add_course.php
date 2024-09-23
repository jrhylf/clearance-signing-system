<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Add Course
if (isset($_POST['course_code'])) {
    // Get input and modify input
    $description = $_POST['course_desc'];
    $course_code = $_POST['course_code'];

    $checkDuplicate = "SELECT * FROM tbl_courses WHERE course_code=? OR course_description=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "ss", $course_code, $description);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);

    if ($duplicateCount > 0) {
        array_push($errors, "Course " . $description . " already exists in the database.");
    } else {
        // Add input to database
        $addToCourses = "INSERT INTO tbl_courses (course_code, course_description) VALUES (?, ?)";
        $stmtAddToCourses = mysqli_prepare($db, $addToCourses);
        mysqli_stmt_bind_param($stmtAddToCourses, "ss", $course_code, $description);
        $addToCoursesResult = mysqli_stmt_execute($stmtAddToCourses);

        if ($addToCoursesResult) {
            array_push($success, "Successfully added $description to Database.");
        }
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
?>