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
    
    <!-- Include Select2 CSS -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="css/select2.min.css">

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <!-- Scripts for Department -->
    <script src="php_page_contents/scripting_processes/delete_dept_script.js"></script>
</head>

<body onload="departmentsTable();">
    <!-- AUTOMATICALLY REFRESH RECORDS WITHOUT RELOADING PAGE -->
    <script type="text/javascript">
        function departmentsTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("departmentsTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/departments_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            departmentsTable();
        }, 2000); // Refreshes records every 2 seconds.
    </script>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_department_modal" onclick="openModal('myModal')">ADD</button>
            <h2>Departments</h2>
            <span>In this module, the admin can add, edit, delete a department.</span>
            <div class="table_container" id="departmentsTable">
                <!-- Table Records -->

                <!-- Script for Edit Button multiple functions. -->
                <script>
                    $(document).ready(function () {
                        $(document).on("click", ".dept-edit-btn", function () {
                            var data_id = $(this).data("id");
                            editRecord(data_id);
                            console.log('Edit Button');
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- MODAL FORM -->
    <script type="text/javascript">
        // Function to open the modal
        function openModal(modalId) {
            var modal = document.getElementById(modalId);
            var overlay = document.querySelector('.overlay');

            if (modal && overlay) {
                modal.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

        // Function to close the modal
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            var overlay = document.querySelector('.overlay');

            if (modal && overlay) {
                modal.style.display = 'none';
                overlay.style.display = 'none';
            }
        }
    </script>

    <!-- The Overlay -->
    <div class="overlay" onclick="closeModal('myModal'); closeModal('editModal')"></div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="add-department-form">
                <h3>Add Department</h3>
                <div class="departments_box">
                    <div class="column">
                        <label for="department_name">Department Name:</label><br>
                        <input type="text" class="dp_name" id="department_name" name="department_name" required><br><br>

                        <?php $courses = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <label for="applicable_course">Applicable Course:</label><br>
                        <select class="dp_dropdown" id="applicable_course" name="applicable_course" required>
                            <option value="All Courses">All Courses</option>
                            <?php while ($row = mysqli_fetch_array($courses)) { ?>
                                <option>
                                    <?php echo $row['course_code'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php $users = mysqli_query($db, "SELECT last_name, first_name FROM tbl_users"); ?>
                        <label for="assigned">Assigned User:</label><br>
                        <input type="text" class="dp_name" id="assigned" name="department_name" value="No User" title="Default value is 'No User'. User should be assigned while adding a user." disabled>
                        <br><br><br>
                        <button type="submit" class="btn" name="add_Department" id="add-department-btn">ADD</button>
                        <button type="button" class="btn" id="btn_clear_dept" onclick="clearFields()">CLEAR</button>
                    </div>
                </div>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>

            <script>
                $(document).ready(function(){
                    $('#add-department-form').on('submit', function(event){
                        event.preventDefault();
                        
                        $.ajax({
                            url: "php_page_contents/add_process/add_department.php",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "text",
                            success: function(response) {
                                var departmentName = $("#department_name").val(); // Get the department name from the input field

                                // Display the success message immediately
                                $('#success-message').html("Department " + departmentName + " added successfully.");
                                console.log("Department '" + departmentName + "' added successfully.");

                                if (response.success) {
                                    // Clear textboxes
                                    clearFields();

                                    // Display success message
                                    $('#success-message').html(response.success);
                                    console.log("Cleared Department");
                                }

                                // Add a delay (e.g., 3 seconds) before fading out and clearing the success message
                                setTimeout(function() {
                                    $('#success-message').fadeOut(1000, function() {
                                        // Animation complete, clear the success message
                                        $('#success-message').html("");
                                    });
                                }, 3000); // 3000 milliseconds = 3 seconds
                            },
                            error: function (response) {
                                $('#error-message').html("Error adding a Department.");
                                console.log("Error adding a Department.");
                                <?php // include("php_page_contents/errors.php"); ?>
                            },
                        });
                    });
                });
            </script>

            <script>
                function clearFields() {
                    $('#department_name').val('');
                    $('#applicable_course').val('All Courses');

                    console.log("Cleared Department Form")
                }
            </script>
        </div>
    </div>

    <!-- Modal for Editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="closeEdit" onclick="closeModal('editModal')">&times;</span>
            <h2>Edit Department</h2>
            <form id="editForm">
                <div class="departments_box">
                    <div class="column">
                        <input type="hidden" id="editDepartmentId" name="id">

                        <label for="editDepartmentName">Department Name:</label>
                        <input type="text" class="dp_name" id="editDepartmentName" name="department_name" required><br><br>

                        <?php $courses = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <label for="applicable_course">Applicable Course:</label><br>
                        <select class="dp_dropdown" id="editApplicableCourse" name="applicable_course" required>
                            <option>All Courses</option>
                            <?php while ($row = mysqli_fetch_array($courses)) { ?>
                                <option>
                                    <?php echo $row['course_code'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="column">
                        <label for="editUser">User:</label>
                        <input type="text" class="dp_name" id="editUser" name="user" disabled>
                        <br><br><br>
                        <button type="button" class="btn" id="editSubmit" onclick="updateRecord()">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editRecord(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_department.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var record = response.data;
                        if (record) {
                            // Populate the modal fields with the record data
                            $('#editDepartmentId').val(record.id);
                            $('#editDepartmentName').val(record.department_name);
                            $('#editApplicableCourse').val(record.applicable_course);
                            $('#editUser').val(record.user);
                            // Save the record for later use
                            window.record = record;
                            // Show the modal
                            $('#editModal').modal('show');
                        } else {
                            alertify.error('Record is null or undefined.');
                            console.log('Record is null or undefined.');
                        }
                    } else {
                        alertify.error('Error fetching record.');
                        console.log('Error fetching record');
                    }
                },
                error: function () {
                    alertify.error('An error occurred during the AJAX request.');
                    console.log('An error occurred during the AJAX request.');
                }
            });
        }

        // Function to update the record using AJAX
        function updateRecord() {
            // Check if record is defined
            if (window.record) {
                var id = $('#editDepartmentId').val();
                var department_name = $('#editDepartmentName').val();
                var applicable_course = $('#editApplicableCourse').val();
                var user = $('#editUser').val();

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_department.php',
                    type: 'POST',
                    data: { id: id, department_name: department_name, applicable_course: applicable_course, user: user },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Handle success, e.g., close the modal, refresh the page, etc.
                            alertify.success('Record updated successfully.');
                            console.log("Record updated successfully.") 
                            $('#editModal').modal('hide');
                        } else {
                            alertify.error('Error updating record.');
                            console.log('Error updating record.');
                        }
                    },
                    error: function () {
                        alertify.error('An error occurred during the AJAX request.');
                        console.log('An error occurred during the AJAX request.');
                    }
                });
            } else {
                alertify.error('Record is not defined.');
                console.log('Record is not defined');
            }
        }
    </script>

    <!-- <script src="js/input_restriction.js"></script> -->
</body>

</html>