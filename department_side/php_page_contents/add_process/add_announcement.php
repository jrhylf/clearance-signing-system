<?php
session_start();
// Database connection
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

// Variables
$response = array('status' => 'error', 'message' => 'Unknown error occurred.');

// Initialize filePath outside the conditional block
$filePath = '';

// Add Announcement
if (isset($_POST['titleAnnouncement'])) {
    // Check if a file was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        // File upload logic
        $fileName = $_FILES['image']['name'];
        $fileType = $_FILES['image']['type'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileError = $_FILES['image']['error'];

        // Check for any errors during file upload
        if ($fileError === UPLOAD_ERR_OK) {
            // Specify the directory to save the uploaded image
            $uploadDirectory = 'announcementImages/';

            // Generate a unique filename for the uploaded image
            $uniqueFileName = $fileName;

            // Move the uploaded file to the desired directory
            $destinationPath = $uploadDirectory . $uniqueFileName;
            move_uploaded_file($fileTmpPath, $destinationPath);

            // Save the file path to your database
            $filePath = $destinationPath;
        } else {
            // Handle file upload errors
            http_response_code(400); // Bad Request
            switch ($fileError) {
                case UPLOAD_ERR_INI_SIZE:
                    $response['message'] = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response['message'] = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response['message'] = 'The uploaded file was only partially uploaded';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response['message'] = 'Missing a temporary folder';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response['message'] = 'Failed to write file to disk';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response['message'] = 'A PHP extension stopped the file upload';
                    break;
                default:
                    $response['message'] = 'Unknown error occurred during file upload';
                    break;
            }

            // Display an error message
            echo json_encode($response);
            exit(); // Exit the script on error
        }
    }

    // Get input and modify input
    $titleAnnouncement = $_POST['titleAnnouncement'];
    $descriptionAnnouncement = $_POST['descriptionAnnouncement'];
    $section = $_POST['announceFor'];
    $startDate = $_POST['startDate'];
    $startTime = $_POST['startTime'];
    $endDate = $_POST['endDate'];
    $endTime = $_POST['endTime'];

    // Check if the announcement title already exists
    $checkDuplicate = "SELECT * FROM tbl_announcements WHERE title=?";
    $stmtCheckDuplicate = mysqli_prepare($db, $checkDuplicate);
    mysqli_stmt_bind_param($stmtCheckDuplicate, "s", $titleAnnouncement);
    mysqli_stmt_execute($stmtCheckDuplicate);
    $checkDuplicateResult = mysqli_stmt_get_result($stmtCheckDuplicate);
    $duplicateCount = mysqli_num_rows($checkDuplicateResult);
    mysqli_stmt_close($stmtCheckDuplicate);

    if ($duplicateCount > 0) {
        $response['message'] = 'Announcement ' . $titleAnnouncement . ' already exists in the database.';
    } else {
        // Add input to database
        $addToAnnouncements = "INSERT INTO tbl_announcements (title, description, announce_for, start_date, start_time, end_date, end_time, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtAddToAnnouncements = mysqli_prepare($db, $addToAnnouncements);
        mysqli_stmt_bind_param($stmtAddToAnnouncements, "ssssssss", $titleAnnouncement, $descriptionAnnouncement, $section, $startDate, $startTime, $endDate, $endTime, $destinationPath);
        $addToAnnouncementsResult = mysqli_stmt_execute($stmtAddToAnnouncements);

        if ($addToAnnouncementsResult) {
            $response = ['status' => 'success', 'message' => 'Successfully added ' . $titleAnnouncement . ' to the database'];

            // Insert Audit Trail for adding a new announcement
            $current_date = date("Y-m-d");
            $current_time = date("h:i:s A");
            $user = $_SESSION['user'];
            $department_name = $_SESSION['department'];
            $activity = "Added a new Announcement {$titleAnnouncement}.";

            $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
            $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
            mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
            $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

            // Close the statement
            mysqli_stmt_close($stmtAddToActivity);
            // Audit Trail end
        }
    }
}

// Return response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
