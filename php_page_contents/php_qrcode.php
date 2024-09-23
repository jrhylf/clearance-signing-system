<?php
include('phpqrcode/qrlib.php');
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/php_dashboard.css">
</head>

<body>
    <div class="reports_box">
        <div class="box">
            <div class="set1">
                <h2 class="acad_info">QR Code</h2>
                <?php
                    // Query to select the active semester
                    $query = "SELECT semester FROM tbl_sy_sem WHERE status = 'active'";
                    $schoolYearQuery = "SELECT CONCAT(sy_start, ' - ', sy_end) AS school_year FROM tbl_sy_sem WHERE status = 'active'";
                    $result = mysqli_query($db, $schoolYearQuery);

                    if ($result) {
                        $row = mysqli_fetch_assoc($result);

                        if ($row) {
                            $schoolYear = $row['school_year'];
                        } else {
                            echo "No data found.";
                        }

                        mysqli_free_result($result); // Free the result set
                    } else {
                        echo "Error executing query: " . mysqli_error($db);
                    }

                    // Perform the query
                    $result = mysqli_query($db, $query);

                    // Check if the query was successful
                    if ($result) {
                        // Fetch the result as an associative array
                        $row = mysqli_fetch_assoc($result);

                        // Check if a row was retrieved
                        if ($row) {
                            // Access the value of the 'semester' column
                            $activeSemester = $row['semester'];

                            if ($activeSemester == 1) {
                                $activeSemester = "1st";
                            } else if ($activeSemester == 2) {
                                $activeSemester = "2nd";
                            }
                        } else {
                            $activeSemester = "No active semester found.";
                        }
                    } else {
                        $result = "Error executing query: " . mysqli_error($db);
                    }
                ?>
                <label class="sy_sem_maintenance">CLEARANCE FOR S.Y. <span class="underline"><?php echo $schoolYear ?></span></label>
                <br>
                <label class="sy_sem_maintenance"><span class="underline"><?php echo $activeSemester ?></span> Semester / Summer</label>
            </div>

            <div class="set2">
                <?php
                    $student_id = $_SESSION['student_id'];
                    $query = "SELECT * FROM tbl_cleared WHERE student_id = ?";
                    $stmt = mysqli_prepare($db, $query);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "s", $student_id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        $row = mysqli_fetch_assoc($result);
                    }
                ?>
                <div class="col">
                    <span class="acad_info" id="student_name" name="studentName">STUDENT NAME: <?php echo $_SESSION['student_name']; ?></span>
                    <span class="acad_info" id="course_code" name="courseCode">COURSE CODE: <?php echo $row['course_code']; ?></span>
                </div>

                <div class="col">
                    <span class="acad_info" id="student_num" name="studentNum">STUDENT NO.: <?php echo $student_id; ?></span>
                    <span class="acad_info" id="section" name="section">SECTION: <?php echo $row['section']; ?></span>
                </div>
            </div>
            
            <div class="set3">
                <div class="generateQrCode">
                    <?php
                        $student_id = $_SESSION['student_id'];
    
                        // Set the directory
                        $path = "php_page_contents/qrcodes/";
                    
                        // Generate a unique filename for the QR code
                        $fileName = 'Student_' . $student_id . '.png';
                        // TODO Dapat di kita pag naka hover sa QR Code
                    
                        // Set absolute and relative file paths
                        $pngAbsoluteFilePath = $path . $fileName;
                        $urlRelativeFilePath = $path . $fileName;
                        $generatedImage = '<img class="qrcode" src="' . $urlRelativeFilePath . '" title="Student_$student_id"/>';
                    
                        // Generate and save the QR code
                        if (!file_exists($pngAbsoluteFilePath)) {
                            // ob_start(); // Start output buffering
                            QRcode::png($student_id, $pngAbsoluteFilePath);
                            echo $generatedImage;
                            // ob_end_clean(); // Clean the output buffer
                            // if ($success) {
                            //     echo $generatedImage;
                            //     echo '<br>File generated!';
                            //     echo '<hr />';
                            // } else {
                            //     echo '<br>Error generating file!';
                            //     echo '<hr />';
                            // }
                        } else {
                            echo $generatedImage;
                        }
                    ?>
                    <form id="refresh">
                        <button type="button" class="btn" id="qrcode_btn" name="refreshqr" onclick="refreshPage()">Refresh</button><br>
                        <span>Please present this QR Code to the respective department.</span>
                    </form>
                    <script>
                        function refreshPage() {
                            location.reload();
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>