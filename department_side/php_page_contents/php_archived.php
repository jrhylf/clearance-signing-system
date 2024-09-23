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
    <link rel="stylesheet" href="css/php_maintenance_contents.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Data table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link rel="stylesheet" href="css/qrscanner.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <!-- Scripts for Students -->
    <script src="php_page_contents/scripting_processes/delete_student_script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Allow only numbers for student ID fields
            var studIdEnterInput = document.getElementById('stud-id-enter');
            var editStudIdEnterInput = document.getElementById('editStud-id-enter');
            studIdEnterInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });
            editStudIdEnterInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });

            // Restrict special characters and numbers for other fields
            var lastnameInput = document.getElementById('lastname');
            var firstnameInput = document.getElementById('firstname');
            var editLastnameInput = document.getElementById('editLastname');
            var editFirstnameInput = document.getElementById('editFirstname');

            var restrictPattern = /[^a-zA-Z\s]/g; // Restrict special characters and digits

            lastnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            firstnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editLastnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editFirstnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });
        });
    </script>
</head>

<body onload="studentsTable()">
    <script type="text/javascript">
        function studentsTable() {
            let table = new DataTable('#tableStudents');
        }
    </script>

    <div class="departments_box">
        <div class="card">
            <!-- // TODO: Export tbl_archived only. -->
            <!-- // TODO: Edit tbl_archived -->
            <!-- // TODO: Delete from tbl_archived -->
            <!-- // TODO: Delete All Checked from tbl_archived -->
            <?php 
                // Check if the department is equal to Registrar
                // if ($department === "Registrar") {
                //     // Render the "Export All" button
                //     echo '<button type="button" class="btn" id="exportAllBtn">Export All</button> ';
                //     echo '<button type="button" class="btn" id="exportRegistrarBtn">Export Registrar Department Only</button>';
                // } else {
                //     echo '<button type="button" class="btn" id="exportRegistrarBtn">Export Records</button>';
                // }
            ?>

            <script>
                $(document).ready(function () {
                    $(document).ready(function() {
                        $('#exportAllBtn').click(function() {
                            window.location.href = 'login_using_msO365/export_all.php';
                            console.log('Export Students');
                        });
                    });

                    $(document).ready(function() {
                        $('#exportRegistrarBtn').click(function() {
                            window.location.href = 'login_using_msO365/export_department.php';
                            console.log('Export Students');
                        });
                    });
                });
            </script>

            <h2>Archived Students</h2>
            <label>In this module, the department can view archived students.</label>
            <div class="table_container" id="studentsTable">
                <!-- Table Records -->
                <?php
                    $department = $_SESSION['department'];
                ?>
                <table id="tableStudents" class="flat-table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Status</th>
                            <th>Student ID</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Remarks</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>School Year</th>
                            <th>Semester</th>
                            <!--<th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if $department is Registrar
                        if ($department === 'Registrar') {
                            $clearedTable = mysqli_query($db, "SELECT * FROM tbl_archived WHERE type = 'Archived' ORDER BY last_name ASC");
                        } else {
                            // If $department is not Registrar, only show records for that department
                            $clearedTable = mysqli_query($db, "SELECT * FROM tbl_archived WHERE department = '$department' AND type = 'Archived' ORDER BY last_name ASC");
                        }

                        if (mysqli_num_rows($clearedTable) > 0) {
                            while ($row = mysqli_fetch_array($clearedTable)) {
                                ?>
                        <tr>
                            <td><input type="checkbox" class="select-checkbox"
                                    data-id="<?php echo $row['student_id']; ?>">
                            </td>
                            <td style="color: <?php echo ($row['status'] == 'OK' && $row['remarks'] == 'Cleared') ? 'green' : 'red'; ?>">
                                <?php
                                if ($row['status'] == 'OK' && $row['remarks'] != 'Cleared') {
                                    // Automatically change to "On-Hold" if 'remarks' is not set to "Cleared"
                                    $row['status'] = 'On-Hold';
                                }
                                echo $row['status'];
                                ?>
                            </td>
                            <td>
                                <?php echo $row['student_id'] ?>
                            </td>
                            <td>
                                <?php echo $row['last_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['first_name'] ?>
                            </td>
                            <td>
                                <?php echo $row['course_code'] ?>
                            </td>
                            <td>
                                <?php echo $row['section'] ?>
                            </td>
                            <td style="color: <?php echo ($row['remarks'] == 'Cleared') ? 'green' : 'red'; ?>">
                                <?php echo $row['remarks']; ?>
                            </td>
                            <td><?php echo $row['department'] ?></td>
                            <td>
                                <?php echo $row['email']; ?>
                            </td>
                            <td>
                                <?php echo $row['school_year']; ?>
                            </td>
                            <td>
                                <?php echo $row['semester']; ?>
                            </td>
                            <!--<td>-->
                            <!--    <button type="button" class="student-edit-btn edit-btn" id="edit_student_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>-->
                            <!--    <button type="button" class="student-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" onclick="console.log('Delete Button')">Delete</button>-->
                            <!--</td>-->
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="11">No records for students.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Export data to .xlsx file -->

                <!-- Script for Edit Button multiple functions. -->
                <script>
                $(document).ready(function() {
                    $(document).on("click", ".student-edit-btn", function() {
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
            <form id="add-student-form">
                <h3>Add Student</h3>
                <div class="form_column">
                    <label for="stud-id-enter">Student ID:</label><br>
                    <input type="text" class="dp_name" id="stud-id-enter" name="student_id" autocomplete="off" required><br>
                    <label for="password">Password:</label><br>
                    <input type="password" class="dp_name" id="password" name="password" autocomplete="off" required>
                    
                    <div class="departments_box">
                        <div class="form_column">
                            <label for="lastname">Last Name:</label><br>
                            <input type="text" class="dp_name" id="lastname" name="lastname" autocomplete="off" required>
                        </div>
                        <div class="form_column">
                            <label for="firstname">First Name:</label><br>
                            <input type="text" class="dp_name" id="firstname" name="firstname" autocomplete="off" required>
                        </div>
                    </div>

                    <label for="email">Email:</label><br>
                    <input type="email" class="dp_name" id="email" name="email" autocomplete="off" required>

                    <div class="departments_box">
                        <div class="form_column">
                            <?php $courses = mysqli_query($conn, "SELECT * FROM tbl_courses"); ?>
                            <label for="course">Course:</label><br>
                            <select class="dp_dropdown" id="course" name="course" autocomplete="off" required>
                                <option value="-Select Course-">-Select Course-</option>
                                <?php while ($row = mysqli_fetch_array($courses)) { ?>
                                <option value="<?php echo ($row['course_code']); ?>">
                                    <?php echo ($row['course_code']); ?>
                                </option>
                                <?php } ?>
                            </select><br><br>
                        </div>
                        <div class="form_column">
                            <?php $sections = mysqli_query($conn, "SELECT * FROM tbl_section"); ?>
                            <label for="section">Section:</label><br>
                            <select class="dp_dropdown" id="section" name="section" autocomplete="off" required>
                                <option value="-Select Section-">-Select Section-</option>
                                <?php while ($row = mysqli_fetch_array($sections)) { ?>
                                <option value="<?php echo ($row['section_number']); ?>">
                                    <?php echo ($row['section_number']); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form_column">
                            <label for="type">Type:</label><br>
                            <select class="dp_dropdown" id="type" name="type" autocomplete="off" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Alumni">Alumni</option>
                                <option value="Returnee">Returnee</option>
                            </select>
                        </div>
                    </div>
                    
                    <label for="remarks">Deficiencies/Balance:</label><br>
                    <!-- // TODO: Show the Edit and Delete button only for the records that has a department value based on what department is logged in. -->
                    <!-- Check if the logged-in department matches the required department -->
                    <!-- <?php 
                        // $logged_in_department = "SELECT * FROM tbl_cleared WHERE department = '$department'";
                        // if ($logged_in_department == $department):
                    ?> -->
                        <!-- Enable the input field -->
                        <input type="text" class="dp_name" id="remarks" name="remarks" autocomplete="off" placeholder="Ex. 1x1 picture, Form137, 2000PHP">
                    <!-- <?php // else: ?> -->
                        <!-- Disable the input field -->
                        <!-- <input type="text" class="dp_name" id="remarks" name="remarks" autocomplete="off" placeholder="Ex. 1x1 picture, Form137, 2000PHP" required disabled> -->
                    <!-- <?php // endif; ?> -->
                </div>
                <br>
                <button type="submit" class="btn" id="btn_add_student" name="add_student">ADD</button>
                <button type="button" class="btn" id="btn_clear_student" onclick="clearFields()">CLEAR</button>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>

            <script>
                $(document).ready(function() {
                    $('#add-student-form').on('submit', function(event) {
                        event.preventDefault();
                        $.ajax({
                            url: "php_page_contents/add_process/add_student.php",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "text",
                            success: function(response) {
                                var studentName = $("#firstname").val() + " " + $("#lastname")
                                    .val();
                                // Display the success message immediately
                                $('#success-message').html("Student " + studentName +
                                    " added successfully.");
                                console.log("Student added successfully.");

                                // Add a delay (e.g., 3 seconds) before fading out and clearing the success message
                                setTimeout(function() {
                                    $('#success-message').fadeOut(1000, function() {
                                        // Animation complete, clear the success message
                                        $('#success-message').html("");
                                    });
                                }, 3000); // 3000 milliseconds = 3 seconds

                                $('#stud-id-enter').val('');
                                $('#password').val('');
                                $('#lastname').val('');
                                $('#firstname').val('');
                                $('#email').val('');
                                $('#course').val('-Select Course-');
                                $('#section').val('-Select Section-');
                                $('#type').val('Active');
                                $('#remarks').val('');
                            },

                            error: function() {
                                $("#error-message").html("Error adding a Student.");
                                console.log("Error adding a Student.");
                            },
                        });
                    });
                });
            </script>

            <script>
            function clearFields() {
                $('#stud-id-enter').val('');
                $('#password').val('');
                $('#lastname').val('');
                $('#firstname').val('');
                $('#email').val('');
                $('#course').val('-Select Course-');
                $('#section').val('-Select Section-');
                $('#type').val('Active');
                $('#remarks').val('');

                alertify.message("Cleared Students Form")
                console.log("Cleared Students Form")
            }
            </script>
        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="closeEdit" onclick="closeModal('editModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-student-form">
                <h3>Edit Student</h3>
                <div class="form_column">
                    <input type="hidden" id="editStudentsId" name="id">
                    <input type="hidden" id="editDepartment" name="department">
                    <input type="hidden" id="editStatus" name="status">
                    
                    <label for="stud-id-enter">Student ID:</label><br>
                    <input type="text" class="dp_name" id="editStud-id-enter" name="student_id" autocomplete="off" required><br>
                    <label for="password">Password:</label><br>
                    <input type="password" class="dp_name" id="editPassword" name="password" autocomplete="off" required>
                    
                    <div class="departments_box">
                        <div class="form_column">
                            <label for="lastname">Last Name:</label><br>
                            <input type="text" class="dp_name" id="editLastname" name="lastname" autocomplete="off" required>
                        </div>
                        <div class="form_column">
                            <label for="firstname">First Name:</label><br>
                            <input type="text" class="dp_name" id="editFirstname" name="firstname" autocomplete="off" required>
                        </div>
                    </div>

                    <label for="email">Email:</label><br>
                    <input type="email" class="dp_name" id="editEmail" name="email" autocomplete="off" required>

                    <div class="departments_box">
                        <div class="form_column">
                            <?php $courses = mysqli_query($conn, "SELECT * FROM tbl_courses"); ?>
                            <label for="course">Course:</label><br>
                            <select class="dp_dropdown" id="editCourse" name="course" autocomplete="off" required>
                                <option value="-Select Course-">-Select Course-</option>
                                <?php while ($row = mysqli_fetch_array($courses)) { ?>
                                <option value="<?php echo ($row['course_code']); ?>">
                                    <?php echo ($row['course_code']); ?>
                                </option>
                                <?php } ?>
                            </select><br><br>
                        </div>
                        <div class="form_column">
                            <?php $sections = mysqli_query($conn, "SELECT * FROM tbl_section"); ?>
                            <label for="section">Section:</label><br>
                            <select class="dp_dropdown" id="editSection" name="section" autocomplete="off" required>
                                <option value="-Select Section-">-Select Section-</option>
                                <?php while ($row = mysqli_fetch_array($sections)) { ?>
                                <option value="<?php echo ($row['section_number']); ?>">
                                    <?php echo ($row['section_number']); ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form_column">
                            <label for="type">Type:</label><br>
                            <select class="dp_dropdown" id="editType" name="type" autocomplete="off" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Alumni">Alumni</option>
                                <option value="Returnee">Returnee</option>
                            </select>
                        </div>
                    </div>
                    
                    <label for="remarks">Deficiencies/Balance:</label><br>
                    <input type="text" class="dp_name" id="editRemarks" name="remarks" autocomplete="off" placeholder="Ex. 1x1 picture, Form137, 2000PHP" required>
                </div>
                <br>
                <button type="button" class="btn" id="editSubmit" onclick="updateRecord()">Update</button>
            </form>
        </div>
    </div>

    <script>
    function editRecord(recordId) {
        $.ajax({
            url: 'php_page_contents/edit_process/fetch_student.php',
            type: 'POST',
            data: {
                id: recordId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var record = response.data;
                    if (record) {
                        console.log(record);
                        // Populate the modal fields with the record data
                        $('#editStudentsId').val(record.id);
                        $('#editDepartment').val(record.department);
                        $('#editStatus').val(record.status);
                        $('#editStud-id-enter').val(record.student_id);
                        $('#editPassword').val(record.password);
                        $('#editLastname').val(record.last_name);
                        $('#editFirstname').val(record.first_name);
                        $('#editEmail').val(record.email);
                        $('#editCourse').val(record.course_code);
                        $('#editSection').val(record.section);
                        $('#editType').val(record.type);
                        $('#editRemarks').val(record.remarks);
                        // Save the record for later use
                        window.record = record;
                        // Show the modal
                        $('#editModal').modal('show');
                        console.log('Edit Modal Showing');
                    } else {
                        alertify.error('Record is null or undefined.');
                        console.log('Record is null or undefined.');
                    }
                } else {
                    alertify.error('Error fetching record.');
                    console.log('Error fetching record');
                }
            },
            error: function() {
                alertify.error('Fetching record error.');
                console.log('Fetching record error.');
            }
        });
    }

    // Function to update the record using AJAX
    function updateRecord() {
        // Check if record is defined
        if (window.record) {
            var id = $('#editStudentsId').val();
            var student_id = $('#editStud-id-enter').val();
            var password = $('#editPassword').val();
            var lastname = $('#editLastname').val();
            var firstname = $('#editFirstname').val();
            var middlename = $('#editMiddlename').val();
            var gender = $('#editGender').val();
            var email = $('#editEmail').val();
            var course = $('#editCourse').val();
            var section = $('#editSection').val();
            var type = $('#editType').val();
            var remarks = $('#editRemarks').val();
            var department = $('#editDepartment').val(); // Assuming you have an element with the id 'editDepartment'
            var status = $('#editStatus').val(); // Assuming you have an element with the id 'editStatus'

            $.ajax({
                url: 'php_page_contents/edit_process/edit_student.php',
                type: 'POST',
                data: {
                    id: id,
                    student_id: student_id,
                    password: password,
                    lastname: lastname,
                    firstname: firstname,
                    middlename: middlename,
                    gender: gender,
                    email: email,
                    course: course,
                    section: section,
                    type: type,
                    remarks: remarks,
                    department: department,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);  // Log the response for debugging
                    if (response.success) {
                        // Handle success
                        alertify.success('Record updated successfully.');
                        console.log("Record updated successfully.")
                        $('#editModal').modal('hide');
                    } else {
                        alertify.error('Error updating record.');
                        console.log('Error updating record.');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);  // Log the error response for debugging
                    alertify.error('Update error record.');
                    console.log('Update error record.');
                }
            });
        } else {
            alertify.error('Record is not defined.');
            console.log('Record is not defined.');
        }
    }
    </script>

    <div class="departments_box">
        <div class="box">
            <h2 class="acad_info">QR Scanner</h2>
            <label class="sy_sem_maintenance">In this module, the department can scan QR codes from students to activate their account.</label>
            <div class="container">
                <h1>Scan QR Codes</h1>
                <div class="section">
                    <div id="my-qr-reader">
                    </div>
                </div>
            </div>
            <script>
                function domReady(fn) {
                    if (
                        document.readyState === "complete" ||
                        document.readyState === "interactive"
                    ) {
                        setTimeout(fn, 1000);
                    } else {
                        document.addEventListener("DOMContentLoaded", fn);
                    }
                }

                domReady(function() {
                    // If found you qr code
                    function onScanSuccess(decodeText, decodeResult) {
                        alertify.success("You Qr is : " + decodeText, decodeResult);
                        console.log("You Qr is : " + decodeText, decodeResult);
                        activateStudentOnServer(decodeText);
                    }

                    // TODO: Make this scan only once.
                    // Create the QR code scanner
                    let htmlscanner = new Html5QrcodeScanner(
                        "my-qr-reader", {
                            fps: 10,
                            qrbos: 250
                        }
                    );
                    // Optional: Add a callback when scanning is done
                    htmlscanner.render(onScanSuccess);
                });

                function activateStudentOnServer(studentId) {
                    // Use AJAX to send a request to a PHP script
                    console.log(studentId);
                    $.ajax({
                        url: "php_page_contents/activate.php",
                        type: "POST",
                        data: {
                            student_id: studentId
                        },
                        dataType: "json", // Change to "html" if your server responds with HTML
                        success: function(response) {
                            if (response.status === 'success') {
                                // Handle the server's response if needed
                                alertify.success(response.message);
                                console.log(response.message);
                                location.reload();
                            } else if (response.status === 'error') {
                                // Handle the server's response if needed
                                alertify.error(response.message);
                                console.log(response.message);
                                location.reload();
                            }
                        },
                        error: function() {
                            // Handle error response
                            alertify.error("Error activating student.");
                            console.error("Error activating student.");
                        }
                    });
                }
            </script>
        </div>
    </div>
    
</body>

</html>