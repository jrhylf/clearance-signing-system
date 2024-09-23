<?php
// Include your database connection code
include('conn.php');

if(isset($_POST['course_code'])){
    $courseCode = $_POST['course_code'];

    // Fetch sections based on the selected course
    $sectionsQuery = mysqli_query($db, "SELECT DISTINCT section_number FROM tbl_section WHERE course_code = '$courseCode' ORDER BY section_number ASC");

    // Build the options for the sections dropdown
    $options = '<option value="-Select Section-">-Select Section-</option>';
    while ($row = mysqli_fetch_array($sectionsQuery)) {
        $options .= '<option value="' . $row['section_number'] . '">' . $row['section_number'] . '</option>';
    }

    // Send the options back as the response
    echo $options;
}
?>
