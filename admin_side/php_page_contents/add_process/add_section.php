<?php
// Database connection
include('conn.php');

// Variables
$success = array();
$errors = array();

// Add Section
if (isset($_POST['section_num'])) {
    // Get input and modify input
    $dd_course_code = $_POST['dd_course_code'];
    $section_num = $_POST['section_num'];
    $section = $dd_course_code . $section_num;

    $checkDuplicate = "SELECT * FROM tbl_section WHERE section=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "s", $section);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);

    if ($duplicateCount > 0) {
        array_push($errors, "Section " . $section . " already exists in the database.");
    } else {
        // Add input to database
        $addToSections = "INSERT INTO tbl_section (course_code, section_number, section) VALUES (?, ?, ?)";
        $stmtAddToSections = mysqli_prepare($db, $addToSections);
        mysqli_stmt_bind_param($stmtAddToSections, "sss", $dd_course_code, $section_num, $section);
        $addToSectionsResult = mysqli_stmt_execute($stmtAddToSections);

        if ($addToSectionsResult) {
            array_push($success, "Successfully added $section to Database.");
        }
    }
}

// Return response as JSON
echo json_encode(array("success" => $success, "error" => $errors));
?>
?>