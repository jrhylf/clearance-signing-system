<?php
include('conn.php');

$department = $_SESSION['department'];
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>
</head>

<body>
    <div class="reports_box">
        <div class="box">
            <!-- Download Reports -->
            <form action="login_using_msO365/export_pdf.php" method="POST">
                <h2 class="acad_info">Reports</h2>
                <label class="sy_sem_maintenance">In this module, the department can track reports.</label>
                
                <input type="submit" name="submit" class="btn" value="Download Reports PDF" />
            </form>
            <!-- Download Reports -->
            <br>
            <br>
            <form action="login_using_msO365/export_course_pdf.php" method="POST" id="exportForm">
                <?php $courses = mysqli_query($db, "SELECT * FROM tbl_courses"); ?>
                <label for="course">Course:</label><br>
                <select class="dp_dropdown" id="course" name="course" autocomplete="off" required>
                    <option value="-Select Course-">-Select Course-</option>
                    <?php while ($row = mysqli_fetch_array($courses)) { ?>
                        <option value="<?php echo ($row['course_code']); ?>">
                            <?php echo ($row['course_code']); ?>
                        </option>
                    <?php } ?>
                </select>
            
                <!-- Add hidden input field to send course_code -->
                <input type="hidden" name="course_code" id="selected_course_code">
            
                <input type="submit" name="submit" class="btn" value="Download Course PDF" />
            </form>
            
            <script>
                $(document).ready(function () {
                    $("#exportForm").submit(function (event) {
                        var selectedCourse = $("#course").val();
        
                        // Check if the selected course is the default option
                        if (selectedCourse === "-Select Course-") {
                            event.preventDefault(); // Prevent form submission
                            alertify.error("Please select a course.");
                        } else {
                            // Set the selected course code before submitting the form
                            $("#selected_course_code").val(selectedCourse);
                        }
                    });
                });
            </script>
            
            <!-- Add JavaScript to set the selected course code -->
            <script>
                $(document).ready(function () {
                    $("#course").change(function () {
                        $("#selected_course_code").val($(this).val());
                    });
                });
            </script>
            <br>
            <hr>
            <br>
            <?php $reports = mysqli_query($db, "SELECT status, student_id, CONCAT(first_name, ' ', last_name) AS full_name, CONCAT(course_code, section) AS course_section, remarks, department FROM tbl_cleared WHERE department = '$department'"); ?>
            <div class="sy_sem_container">
                <h4><?php echo $department . " Students' Clearance"; ?></h4>
                <table id="report-table-body" class="sy_sem_table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course & Section</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <?php while ($row = mysqli_fetch_array($reports)) { ?>
                        <tbody>
                            <tr>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['student_id']; ?></td>
                                <td><?php echo $row['full_name']; ?></td>
                                <td><?php echo $row['course_section']; ?></td>
                                <td><?php echo $row['remarks']; ?></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>