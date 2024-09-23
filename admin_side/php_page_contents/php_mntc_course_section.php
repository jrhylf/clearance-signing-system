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
    <!-- <link rel="stylesheet" href="css/select2.min.css"> -->

    <!-- Include Select2 JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <!-- Scripts for Course Section -->
    <script src="php_page_contents/scripting_processes/delete_course_script.js"></script>
    <script src="php_page_contents/scripting_processes/delete_section_script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Allow only numbers for student ID fields
            var sectionInput = document.getElementById('section-enter');
            var editSectionInput = document.getElementById('edit-section-enter');
            sectionInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });
            editSectionInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });

            var courseInput = document.getElementById('course-enter');
            var courseCodeInput = document.getElementById('course-code-enter');
            var editCourseInput = document.getElementById('edit-course-enter');
            var editCourseCodeInput = document.getElementById('edit-course-code-enter');

            var restrictPattern = /[^a-zA-Z\s]/g; // Restrict special characters and digits

            courseInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            courseCodeInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editCourseInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editCourseCodeInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });
        });
    </script>
</head>

<body onload="courseTable(), sectionTable()">

    <script type="text/javascript">
        // Course Auto Refresh Data
        function courseTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("courseTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/courses_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            courseTable();
        }, 1000);

        // Section Auto Refresh Data
        function sectionTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("sectionTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/sections_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            sectionTable();
        }, 1000);
    </script>

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

        // Function to open the edit modal
        function openEditModal(editModalId) {
            var modal = document.getElementById(editModalId);
            var overlay = document.querySelector('.overlay');

            if (modal && overlay) {
                modal.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

        // Function to close the edit modal
        function closeEditModal(editModalId) {
            var modal = document.getElementById(editModalId);
            var overlay = document.querySelector('.overlay');

            if (modal && overlay) {
                modal.style.display = 'none';
                overlay.style.display = 'none';

                // Reset the content of the modal when closing
                modal.innerHTML = '';
            }
        }
    </script>

    <!-- The Overlay -->
    <div class="overlay" onclick="closeModal('course_Modal'); closeModal('section_Modal'); closeEditModal('edit_course_Modal'); closeEditModal('edit_section_Modal') "></div>

    <h2>Course and Section</h2>
    <label>In this module, the admin can add, edit, delete courses and sections.</label>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_course_modal" onclick="openModal('course_Modal')">ADD</button>
            <h2>Course</h2>
            <label>In this module, the admin can add, edit, delete course.</label>
            <div class="table_container" id="courseTable">

                <!-- Script for Edit Button multiple functions. -->
                <script>
                    $(document).ready(function () {
                        $(document).on("click", ".course-edit-btn", function () {
                            var data_id = $(this).data("id");
                            editCourse(data_id);
                            console.log('Edit Course Button');
                        });
                    });

                    $(document).ready(function () {
                        $(document).on("click", ".section-edit-btn", function () {
                            var data_id = $(this).data("id");
                            editSection(data_id);
                            console.log('Edit Section Button');
                        });
                    });
                </script>

            </div>
        </div>
    </div>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_section_modal" onclick="openModal('section_Modal')">ADD</button>
            <h2>Section</h2>
            <label>In this module, the admin can add, edit, delete section.</label>
            <div class="table_container" id="sectionTable">

            </div>
        </div>
    </div>

    <!-- <div class="departments_box">
        <div class="card">
            <h2>Batch Upload</h2>
            <form action="#" method="POST" autocomplete="off">
                <input type="file" class="select_file" id="csv_file">
                <button type="submit" class="btn">Upload</button>
            </form>
        </div>
    </div> -->

    <div id="course_Modal" class="courseModal">
        <div class="course-modal-content">
            <span class="close_course" onclick="closeModal('course_Modal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="add-course-form">
                <h3>Add Course</h3>
                <label for="course-enter">Course Description:</label><br>
                <input type="text" class="course_desc" id="course-enter" name="course_desc" required><br><br>

                <label for="course-code-enter">Course Code:</label><br>
                <input type="text" class="course_code" id="course-code-enter" name="course_code" required>

                <br><br>
                <button type="submit" class="btn_add_coursec" name="add_course">ADD</button>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#add-course-form').on('submit', function(event){
                event.preventDefault();
                
                $.ajax({
                    url: "php_page_contents/add_process/add_course.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(response) {
                        var course_desc = $("#course-enter").val();
                        // Display a success message immediately
                        $('#success-message').html("Course " + course_desc + " added successfully.");
                        console.log("Course added successfully.");

                        // TODO: Clear the form fields after successful submission
                        $('#course-enter').val('');
                        $('#course-code-enter').val('');

                        // Add a delay (e.g., 3 seconds) before clearing the success message
                        setTimeout(function() {
                            $('#success-message').fadeOut(1000, function() {
                                // Animation complete, clear the success message
                                $('#success-message').html("");
                            });
                        }, 3000); // 3000 milliseconds = 3 seconds
                    },
                    error: function () {
                        $("#error-message").html("Error adding a Course.");
                        console.log("Error adding a Course.");
                    },
                });
            });
        });
    </script>

    <div id="section_Modal" class="sectionModal">
        <div class="section-modal-content">
            <span class="close_section" onclick="closeModal('section_Modal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="add-section-form">
                <h3>Add Section</h3>
                <?php $course_code = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                <label for="assigned">Select Course Code:</label><br>
                <select class="cc_dropdown" id="assigned" name="dd_course_code" required>
                    <option value="select">-Select Course Code-</option>
                    <?php while ($row = mysqli_fetch_array($course_code)) { ?>
                        <option value="<?php echo $row['course_code'] ?>">
                            <?php echo $row['course_code'] ?>
                        </option>
                    <?php } ?>
                </select><br><br>

                <label for="section-enter">Section Number:</label><br>
                <input type="text" class="section_num" id="section-enter" name="section_num" required>

                <br><br>
                <button type="submit" class="btn_add_coursec" name="add_section">ADD</button>
            </form>

            <div id="success-message" style="color: green;"></div> <!-- NOT SHOWING -->
            <div id="error-message" style="color: red;"></div> <!-- NOT SHOWING -->
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#add-section-form').on('submit', function(event){
                event.preventDefault();
                
                $.ajax({
                    url: "php_page_contents/add_process/add_section.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "text",
                    success: function(response) {
                        var section = $("#assigned").val() + $("#section-enter").val(); // Get the section information from an input field, if available

                        // Display the success message immediately
                        $('#success-message').html("Section " + section + " added successfully.");
                        console.log("Section added successfully.");

                        // Add a delay (e.g., 3 seconds) before fading out and clearing the success message
                        setTimeout(function() {
                            $('#success-message').fadeOut(1000, function() {
                                // Animation complete, clear the success message
                                $('#success-message').html("");
                            });
                        }, 3000); // 3000 milliseconds = 3 seconds
                    },

                    error: function () {
                        $("#error-message").html("Error adding a Section.");
                        console.log("Error adding a Section.");
                    },
                });
            });
        });
    </script>

    <!-- Modal for Editing -->
    <div id="edit_course_Modal" class="courseModal">
        <div class="course-modal-content">
            <span class="closeEdit" onclick="closeEditModal('edit_course_Modal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-course-form">
                <h3>Edit Course</h3>
                <input type="hidden" id="editCourseId" name="id">
                <label for="edit-course-enter">Course Description:</label><br>
                <input type="text" class="course_desc" id="edit-course-enter" name="edit_course_desc" required><br><br>

                <label for="edit-course-code-enter">Course Code:</label><br>
                <input type="text" class="course_code" id="edit-course-code-enter" name="edit_course_code" required>

                <br><br>
                <button type="button" class="btn" id="editSubmit" onclick="updateCourse()">Update</button>
            </form>
        </div>
    </div>

    <script>
        function editCourse(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_course.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var record = response.data;
                        if (record) {
                            // Populate the modal fields with the record data
                            $('#editCourseId').val(record.id);
                            $('#edit-course-enter').val(record.course_description);
                            $('#edit-course-code-enter').val(record.course_code);
                            // Save the record for later use
                            window.record = record;
                            // Show the modal
                            $('#edit_course_Modal').modal('show');
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

        function updateCourse() {
            if (window.record) {
                var id = $('#editCourseId').val();
                var course = $('#edit-course-enter').val();
                var course_code = $('#edit-course-code-enter').val();

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_course.php',
                    type: 'POST',
                    data: { id: id, course_code: course_code, course: course }, // Consistent naming
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            alertify.success('Record updated successfully.');
                            console.log('Record updated successfully.');
                            $('#edit_course_Modal').modal('hide');
                        } else {
                            alertify.error('Error updating record: ' + response.message);
                            console.log('Error updating record:', response.message);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alertify.error('An error occurred during the AJAX request. ' + errorThrown);
                        console.log('An error occurred during the AJAX request.', jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                alertify.error('Record is not defined.');
                console.log('Record is not defined');
            }
        }
    </script>

    <div id="edit_section_Modal" class="sectionModal">
        <div class="section-modal-content">
            <span class="closeEdit" onclick="closeEditModal('edit_section_Modal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-section-form">
                <h3>Edit Section</h3>
                <input type="hidden" id="editSectionId" name="id">
                <?php $course_code = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                <label for="edit-assigned">Select Course Code:</label><br>
                <select class="cc_dropdown" id="edit-assigned" name="dd_course_code" required>
                    <option value="select">-Select Course Code-</option>
                    <?php while ($row = mysqli_fetch_array($course_code)) { ?>
                        <option value="<?php echo $row['course_code'] ?>">
                            <?php echo $row['course_code'] ?>
                        </option>
                    <?php } ?>
                </select><br><br>

                <label for="edit-section-enter">Section Number:</label><br>
                <input type="text" class="section_num" id="edit-section-enter" name="section_num" required>

                <br><br>
                <button type="button" class="btn" id="editSubmit" onclick="updateSection()">Update</button>
            </form>
        </div>
    </div>

    <script>
        function editSection(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_section.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var record = response.data;
                        if (record) {
                            // Populate the modal fields with the record data
                            $('#editSectionId').val(record.id);
                            $('#edit-assigned').val(record.course_code);
                            $('#edit-section-enter').val(record.section_number);
                            // Save the record for later use
                            window.record = record;
                            // Show the modal
                            $('#edit_section_Modal').modal('show');
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
        function updateSection() {
            // Check if record is defined
            if (window.record) {
                var id = $('#editSectionId').val();
                var course_code = $('#edit-assigned').val();
                var section_number = $('#edit-section-enter').val();

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_section.php',
                    type: 'POST',
                    data: { id: id, course_code: course_code, section_number: section_number },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Handle success, e.g., close the modal, refresh the page, etc.
                            alertify.success('Record updated successfully.');
                            console.log("Record updated successfully.") 
                            $('#edit_section_Modal').modal('hide');
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