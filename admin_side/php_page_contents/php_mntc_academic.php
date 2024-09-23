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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <!-- Scripts for School Year -->
    <script src="php_page_contents/scripting_processes/delete_sy_script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Allow only numbers for student ID fields
            var startYearInput = document.getElementById('start_year');
            var endYearInput = document.getElementById('end_year');
            var semesterInput = document.getElementById('semester');
            var editStartYearInput = document.getElementById('editStart_year');
            var editEndYearInput = document.getElementById('editEnd_year');
            var editSemesterInput = document.getElementById('editSemester');

            [startYearInput, endYearInput, semesterInput, editStartYearInput, editEndYearInput, editSemesterInput].forEach(function (input) {
                input.addEventListener('input', function () {
                    this.value = this.value.replace(/\D/g, ''); // Allow only digits
                });
            });

            // Restrict special characters for other fields
            var statusInput = document.getElementById('status');

            var restrictPattern = /[^a-zA-Z\s]/g; // Restrict special characters

            statusInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });
        });
    </script>
</head>

<body>
    <div class="departments_box">
        <div class="box">
            <h2>Academic Information</h2>
            <label>In this module, the admin can update the current Class Start.</label>
        </div>
    </div>
    <div class="departments_box">
        <div class="card">
            <h2>Set School Year</h2>
            <form id="schoolYearForm">
                <div class="sySemContainer">
                    <label for="start_year">Start</label><br>
                    <input type="text" class="dp_name" id="start_year" name="start_year" required><br>
                    <label for="end_year">End</label><br>
                    <input type="text" class="dp_name" id="end_year" name="end_year" required><br>
                    <label for="semester">Semester</label><br>
                    <input type="text" class="dp_name" id="semester" name="semester" required><br>
                    <label for="status">Status</label>
                    <select name="status" class="dp_dropdown" id="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn_update_sy" name="update_school_year">ADD</button>
                <button type="button" class="btn" id="btn_clear_student" onclick="clearFields()">CLEAR</button>
            </form>

            <script>
                $(document).ready(function () {
                    $("#schoolYearForm").submit(function (event) {
                        event.preventDefault();

                        var startYear = $("#start_year").val();
                        var endYear = $("#end_year").val();
                        var semester = $("#semester").val();
                        var status = $("#status").val();

                        // Polished AJAX Showing Message
                        $.ajax({
                            url: "php_page_contents/add_process/add_school_year.php",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "json", // Set the expected data type to JSON
                            success: function (response) {
                                if (response.status === 'error') {
                                    alertify.error(response.message);
                                    console.log(response.message);
                                    // TODO: Reload Table
                                } else if (response.status === 'success') {
                                    alertify.success(response.message);
                                    console.log(response.message);
                                    // Add any additional actions after a successful submission
                                    $('#start_year').val('');
                                    $('#end_year').val('');
                                    $('#semester').val('');
                                    $('#status').val('Active');
                                }
                            },
                            error: function (error) {
                                console.log(error);
                                alertify.error("An error occurred. Please try again.");
                            }
                        });
                    });
                });

                function clearFields() {
                    $('#start_year').val('');
                    $('#end_year').val('');
                    $('#semester').val('');
                    $('#status').val('Active');

                    alertify.message("Cleared School Year Form")
                    console.log("Cleared School Year Form")
                }
            </script>
        </div>
    </div>

    <div class="departments_box">
        <div class="card">
            <h2>School year</h2>
            <label>In this module, the admin can add, edit, delete school year.</label>
            <div class="table_container" id="schoolYearTable">
                <!-- Table Records -->
                <table id="tableSchoolYear" class="flat-table">
                    <thead>
                        <tr>
                            <th>School Year</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $schoolYearTable = mysqli_query($db, "SELECT * FROM tbl_sy_sem ORDER BY sy_start, semester ASC");
                        if (mysqli_num_rows($schoolYearTable) > 0) {
                            while ($row = mysqli_fetch_array($schoolYearTable)) {
                                ?>
                        <tr>
                            <td>
                                <?php echo $row['sy_start'] . '-' . $row['sy_end']?>
                            </td>
                            <td>
                                <?php echo $row['semester'] ?>
                            </td>
                            <td style="color: <?php echo ($row['status'] == 'Active') ? 'green' : 'red'; ?>">
                                <?php echo $row['status'] ?>
                            </td>
                            <td>
                                <button type="button" class="sy-edit-btn edit-btn" id="edit_student_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>
                                <button type="button" class="sy-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" onclick="console.log('Delete Button')">Delete</button>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="11">No records for students.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Script for Edit Button multiple functions. -->
                <script>
                    $(document).ready(function() {
                        $(document).on("click", ".sy-edit-btn", function() {
                            var data_id = $(this).data("id");
                            editRecord(data_id);
                            console.log('Edit Button');
                        });
                    });
                </script>

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
                <div class="overlay" onclick="closeModal('editModal')"></div>

                <!-- Add the modal form inside your HTML body -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('editModal')">&times;</span>
                        <form id="editSchoolYearForm">
                            <input type="hidden" id="editSchoolYearId" name="id">

                            <label for="editStart_year">Start</label><br>
                            <input type="text" class="dp_name" id="editStart_year" name="start_year" required><br>
                            <label for="editEnd_year">End</label><br>
                            <input type="text" class="dp_name" id="editEnd_year" name="end_year" required><br>
                            <label for="editSemester">Semester</label><br>
                            <input type="text" class="dp_name" id="editSemester" name="semester" required><br>
                            <label for="editStatus">Status</label>
                            <select class="dp_dropdown" id="editStatus" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <button type="button" class="btn" onclick="updateRecord()">UPDATE</button>
                        </form>
                    </div>
                </div>
                <script>
                    function editRecord(recordId) {
                        $.ajax({
                            url: 'php_page_contents/edit_process/fetch_school_year.php',
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
                                        $('#editSchoolYearId').val(record.id);
                                        $('#editStart_year').val(record.sy_start);
                                        $('#editEnd_year').val(record.sy_end);
                                        $('#editSemester').val(record.semester);
                                        $('#editStatus').val(record.status);
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
                                    console.log('Error fetching record.');
                                }
                            },
                            error: function() {
                                alertify.error('Error fetching record.');
                                console.log('Error fetching record.');
                            }
                        });
                    }

                    // Function to update the school year record using AJAX
                    function updateRecord() {
                        // TODO: Validate if #editStartYear have same value with #editEnd_year
                        if (window.record) {
                            var id = $('#editSchoolYearId').val();
                            var sy_start = $('#editStart_year').val();
                            var sy_end = $('#editEnd_year').val();
                            var semester = $('#editSemester').val();
                            var status = $('#editStatus').val();
                            
                            $.ajax({
                                url: 'php_page_contents/edit_process/edit_school_year.php',
                                type: 'POST',
                                data: {
                                    id: id,
                                    sy_start: sy_start,
                                    sy_end: sy_end,
                                    semester: semester,
                                    status: status
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);  // Log the response for debugging
                                    if (response.success) {
                                        // Handle success
                                        alertify.success(response.message);
                                        console.log(response.message)
                                        $('#editModal').modal('hide');
                                    } else {
                                        alertify.error(response.message);
                                        console.log(response.message);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(xhr.responseText);  // Log the error response for debugging
                                    alertify.error('Error Updating Record.');
                                    console.log('Error Updating Record.');
                                }
                            });
                        } else {
                            alertify.error('Record is not defined.');
                            console.log('Record is not defined.');
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</body>

</html>