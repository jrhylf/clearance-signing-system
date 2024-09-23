<?php
include('conn.php');

// Set the timezone to Philippine Standard Time (UTC+8)
date_default_timezone_set('Asia/Manila');

// Check connection
if (mysqli_connect_error()) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Content-Type: application/json'); // Move this to the top to ensure JSON header

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the student_id from the AJAX request
    $studentId = $_POST['student_id'];

    // Check if the student's type is already Active
    $checkSql = "SELECT type FROM tbl_archived WHERE student_id = ?";
    $checkStmt = $db->prepare($checkSql);
    $checkStmt->bind_param("s", $studentId);
    $checkStmt->execute();
    $checkStmt->bind_result($currentType);

    if ($checkStmt->fetch()) {
        $checkStmt->close();

        if ($currentType !== "Active") {
            // Transfer records from tbl_archived to tbl_cleared using prepared statement
            $insertQuery = "INSERT INTO tbl_cleared SELECT * FROM tbl_archived";
            $insertStatement = $db->prepare($insertQuery);
            $insertSuccess = $insertStatement->execute();

            if ($insertSuccess) {
                // Update the type in tbl_cleared using prepared statement
                $updateSql = "UPDATE tbl_cleared SET type = 'Active' WHERE student_id = ?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("s", $studentId);
                
                // Insert Audit Trail
                $current_date = date("Y-m-d");
                $current_time = date("h:i:s A");
                $user = $_SESSION['user'];
                $department_name = $_SESSION['department'];
                $activity = "Student activated " . $studentId . ".";
            
                $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
                $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
                mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
                $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);
            
                // Execute the statement and check for errors
                if ($addToActivityResult) {
                    echo json_encode(array('success' => true, 'message' => 'Audit trail inserted successfully.'));
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Error inserting audit trail: ' . mysqli_error($db)));
                }
            
                // Close the statement
                mysqli_stmt_close($stmtAddToActivity);

                if ($updateStmt->execute()) {
                    // Fetch 'sy_start' . '-' . 'sy_end' and 'semester' FROM tbl_sy_sem WHERE status = 'Active'
                    $syStartQuery = "SELECT sy_start FROM tbl_sy_sem WHERE status = 'Active'";
                    $syEndQuery = "SELECT sy_end FROM tbl_sy_sem WHERE status = 'Active'";
                    $activeSemesterQuery = "SELECT semester FROM tbl_sy_sem WHERE status = 'Active'";
                    $activeSection = "SELECT section FROM tbl_cleared WHERE student_id = $studentId ";

                    $syStartResult = $db->query($syStartQuery);
                    $syEndResult = $db->query($syEndQuery);
                    $activeSemesterResult = $db->query($activeSemesterQuery);
                    $sectionResult = $db->query($activeSection);

                    if ($syStartResult && $syEndResult && $activeSemesterResult && $sectionResult) {
                        $syStart = $syStartResult->fetch_assoc()['sy_start'];
                        $syEnd = $syEndResult->fetch_assoc()['sy_end'];
                        $activeSchoolYear = $syStart . '-' . $syEnd;
                        $activeSemester = $activeSemesterResult->fetch_assoc()['semester'];
                        $sectionResultArray = $sectionResult->fetch_assoc()['section'];

                        // Condition if section == '111, 211, 311, 411, 711, or 811'
                        switch ($sectionResultArray) {
                            case '111':
                                $currentSection = '211';
                                break;
                            case '211':
                                $currentSection = '311';
                                break;
                            case '311':
                                $currentSection = '411';
                                break;
                            case '411':
                                $currentSection = '511';
                                break;
                            case '511':
                                $currentSection = '611';
                                break;
                            case '611':
                                $currentSection = '711';
                                break;
                            case '711':
                                $currentSection = '811';
                                break;
                            default:
                                $currentSection = '111';
                                break;
                        }

                        // Update the section, school_year, and semester in tbl_cleared using prepared statement
                        $updateSql = "UPDATE tbl_cleared SET section = ?, school_year = ?, semester = ? WHERE student_id = ?";
                        $updateStmt = $db->prepare($updateSql);

                        if ($updateStmt) {
                            $updateStmt->bind_param("ssss", $currentSection, $activeSchoolYear, $activeSemester, $studentId);
                            $updateResult = $updateStmt->execute();

                            if ($updateResult) {
                                echo json_encode(array("status" => "success", "message" => "Updated school year and semester successfully."));
                            } else {
                                echo json_encode(array("status" => "error", "message" => "Error updating record: " . $updateStmt->error));
                            }

                            $updateStmt->close();
                        } else {
                            echo json_encode(array("status" => "error", "message" => "Error preparing update statement: " . $db->error));
                        }

                    } else {
                        echo json_encode(array("status" => "error", "message" => "Error fetching active semester details: " . $db->error));
                    }
                }
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to Activate student."));
            }
        } else {
            echo json_encode(array("status" => "error", "message" => "Already Active!"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Error fetching current type: " . $checkStmt->error));
    }
} else {
    // Handle invalid request
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}

$db->close();
?>
