<?php
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
    <div class="summary_content">
        <div class="box_summary">
            <?php $departments = mysqli_query($db, "SELECT COUNT(id) FROM tbl_departments"); ?>
            <div class="column">
                <img src="images/dept.png" class="icons" alt="department" style="width: 50px; height: 50px;">
            </div>
            <div class="column">
                <h4 class="total">Total</h4>
                <label class="labels">
                    <?php while ($row = mysqli_fetch_array($departments)) { ?>
                        <span>
                            <?php echo $row['COUNT(id)'] ?>
                        </span>
                        <?php
                        if ($row['COUNT(id)'] <= 1) {
                            echo "Department";
                        } else if ($row['COUNT(id)'] > 1) {
                            echo "Departments";
                        }
                        ?>
                    <?php } ?>

                </label>
            </div>
        </div>
        <div class="box_summary">
            <?php $users = mysqli_query($db, "SELECT COUNT(id) FROM tbl_users"); ?>
            <div class="column">
                <img src="images/users.png" class="icons" alt="users" style="width: 50px; height: 50px;">
            </div>
            <div class="column">
                <h4 class="total">Total</h4>
                <label class="labels">
                    <?php while ($row = mysqli_fetch_array($users)) { ?>
                        <span>
                            <?php echo $row['COUNT(id)'] ?>
                        </span>
                        <?php
                        if ($row['COUNT(id)'] <= 1) {
                            echo "User";
                        } else if ($row['COUNT(id)'] > 1) {
                            echo "Users";
                        }
                        ?>
                    <?php } ?>
                </label>
            </div>
        </div>
        <div class="box_summary">
            <?php $students_query = mysqli_query($db, "SELECT COUNT(DISTINCT student_id) as student_count FROM tbl_cleared"); ?>
            <div class="column">
                <img src="images/students.png" class="icons" alt="students" style="width: 50px; height: 50px;">
            </div>
            <div class="column">
                <h4 class="total">Total</h4>
                <label class="labels">
                    <?php while ($row = mysqli_fetch_array($students_query)) { ?>
                        <span>
                            <?php echo $row['student_count'] ?>
                        </span>
                        <?php
                        if ($row['student_count'] <= 1) {
                            echo "Student";
                        } else if ($row['student_count'] > 1) {
                            echo "Students";
                        }
                        ?>
                    <?php } ?>
                </label>
            </div>
        </div>
    </div>

    <div class="reports_box">
        <div class="box">
            <!-- Download Reports -->
            <form action="login_using_msO365/export_pdf.php" method="POST">
                <h2 class="acad_info">Reports</h2>
                <label class="sy_sem_maintenance">In this module, the admin can track reports from departments.</label>
                <input type="submit" name="submit" class="btn" value="Download Reports PDF" />
            </form>
            <!-- Download Reports -->
            <br>
            <hr>
            <br>
            <?php $reports = mysqli_query($db, "SELECT status, student_id, CONCAT(first_name, ' ', last_name) AS full_name, CONCAT(course_code, section) AS course_section, remarks, department FROM tbl_cleared"); ?>
            <div class="sy_sem_container">
                <h4><?php echo "All Students' Clearance"; ?></h4>
                <table id="report-table-body" class="sy_sem_table">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Course & Section</th>
                            <th>Remarks</th>
                            <th>Department</th>
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
                                <td><?php echo $row['department']; ?></td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>