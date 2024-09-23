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
    <link rel="stylesheet" href="css/php_maintenance_contents.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <!-- <div class="departments_box">
        <div class="box">
            <a href="#add_department_form"><button type="submit" class="btn" id="section_add_btn">ADD</button></a>
            <h2>Departments</h2>
            <label>In this module, the admin can add, edit, delete a department.</label>
            <div class="table_container">
                <table class="flat-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Department Name</th>
                            <th>User</th>
                            <th>Applicable Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // $departmentTable = mysqli_query($db, "SELECT * FROM tbl_departments"); ?>
                        <?php // while ($row = mysqli_fetch_array($departmentTable)) { ?>
                            <tr>
                                <td><?php // echo $row['id']; ?></td>
                                <td><?php // echo $row['department_name']; ?></td>
                                <td><?php // echo $row['user']; ?></td>
                                <td><?php // echo $row['applicable_course']; ?></td>
                                <td>


                                    <button class="edit-btn" id="btn-edit">Edit</button>
                                    <button class="delete-btn" onclick="deleteDepartment(<?php // echo $row['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php // } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <section id="add_department_form"></section>

    <div class="departments_box">
        <div class="card">
            <h2>Batch Upload</h2>
            <form action="#" method="POST" autocomplete="off">
                <input type="file" class="select_file" id="csv_file">
                <button type="submit" class="btn">Upload</button>
            </form>
        </div>
    </div>
    <div class="departments_box">
        <div class="card">
            <h2>Add Department</h2>
            <form action="php_page_contents/php_mntc_departments.php" method="POST" autocomplete="off" id="myForm">
                <?php // include('errors.php'); ?>
                <?php // include('successPrompt.php'); ?>
                <div class="departments_box">
                    <div class="column">
                        <label for="dp_name">Department Name:</label><br>
                        <input type="text" class="dp_name" id="dp_name" name="department_name"><br><br>

                        <?php // $courses = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <label for="applicable_course">Applicable Course:</label><br>
                        <select class="dp_dropdown" id="applicable_course" name="applicable_course">
                            <option value="all">All Courses</option>
                            <?php // while ($row = mysqli_fetch_array($courses)) { ?>
                                <option value="course">
                                    <?php // echo $row['course_code'] ?>
                                </option>
                            <?php // } ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php // $users = mysqli_query($db, "SELECT last_name, first_name FROM tbl_users"); ?>
                        <label for="assigned">Assigned User:</label><br>
                        <select class="dp_dropdown" id="assigned" name="assigned_user">
                            <option value="select">-Select User-</option>
                            <?php // while ($row = mysqli_fetch_array($users)) { ?>
                                <option value="user">
                                    <?php // echo $row['last_name'] . ", " . $row['first_name'] ?>
                                </option>
                            <?php // } ?>
                        </select>
                        <br><br><br>
                        <button type="submit" class="btn" name="add_Department">ADD</button>

                    </div>
                </div>
            </form>
            <button type="submit" class="btn" id="btn_clear_dept" onclick="clearFields()">CLEAR</button>
            <script>
                function clearFields() {
                    // Get all the input elements in the form
                    var inputs = document.getElementsByTagName("input");

                    // Loop through each input element
                    for (var i = 0; i < inputs.length; i++) {
                        // Clear the input field value
                        inputs[i].value = "";
                    }
                }
            </script>
        </div>
    </div>
    <script type="text/javascript">
        function deleteDepartment(delID) {
            if (confirm("Are you sure you want to delete this department?")) {
                window.location.href = 'php_page_contents/delete_process_mntc.php?delDept=' + delID;
            }
        }
    </script> -->
    <!-- <script src="js/input_restriction.js"></script> -->

    // TODO: UI NG AUDIT TRAIL TABLE FOR SPECIFIC LOGGED IN DEPARTMENT. VIEWING ONLY.
</body>

</html>