<?php
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
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

    <!-- Scripts for Department -->
    <script src="php_page_contents/scripting_processes/delete_admin_script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Allow only numbers for student ID fields
            var contactInput = document.getElementById('contact');
            var editContactInput = document.getElementById('edit_contact');
            contactInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });
            editContactInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, ''); // Allow only digits
            });

            // Restrict special characters and numbers for other fields
            var lastnameInput = document.getElementById('lastname');
            var firstnameInput = document.getElementById('firstname');
            var positionInput = document.getElementById('position');
            var editLastnameInput = document.getElementById('edit_lastname');
            var editFirstnameInput = document.getElementById('edit_firstname');
            var editPositionInput = document.getElementById('edit_position');

            var restrictPattern = /[^a-zA-Z\s]/g; // Restrict special characters and digits

            lastnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            firstnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            positionInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editLastnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editFirstnameInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });

            editPositionInput.addEventListener('input', function () {
                this.value = this.value.replace(restrictPattern, '');
            });
        });
    </script>
</head>
</head>

<body onload="adminTable();">
    <!-- AUTOMATICALLY REFRESH RECORDS WITHOUT RELOADING PAGE -->
    <script type="text/javascript">
        function adminTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("adminTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/admin_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            adminTable();
        }, 2000); // Refreshes records every 2 seconds.
    </script>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_admin_modal" onclick="openModal('myModal')">ADD</button>
            <h2>Administrator</h2>
            <span>In this module, the admin can add, edit, delete an administrator except for the main admin.</span>
            <div class="table_container" id="adminTable">
                <!-- Table Records -->

                <!-- Script for Edit Button multiple functions. -->
                <script>
                    $(document).ready(function () {
                        $(document).on("click", ".admin-edit-btn", function () {
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
        <div class="admin-modal-content">
            <span class="close" onclick="closeModal('myModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="add-admin-form">
                <h3>Add Administrator</h3>
                <div class="admin_box">
                    <div class="column_admin">
                        <label for="lastname">Last Name:</label><br>
                        <input type="text" class="dp_name" id="lastname" name="lastname" required><br><br>

                        <label for="firstname">First Name:</label><br>
                        <input type="text" class="dp_name" id="firstname" name="firstname" required><br><br>

                        <label for="contact">Contact:</label><br>
                        <input type="text" class="dp_name" id="contact" name="contact" required><br><br>

                        <label for="email">Email:</label><br>
                        <input type="email" class="dp_name" id="email" name="email" required><br><br>

                        <label for="username">Username:</label><br>
                        <input type="text" class="dp_name" id="username" name="username" autocomplete="off" required><br><br>

                        <label for="password">Password:</label><br>
                        <input type="password" class="dp_name" id="password" name="password" autocomplete="off" required><br><br>

                        <label for="position">Position:</label><span class="optional"> (Optional)</span><br>
                        <input type="text" class="dp_name" id="position" name="position" autocomplete="off" placeholder="default: Administrator" value="Administrator"><br><br>
                    </div>
                </div><br>
                <button type="submit" class="btn" name="add_Admin" id="add-admin-btn">ADD</button>
                <button type="button" class="btn" id="btn_clear_admin" onclick="clearFields()">CLEAR</button>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>
            <?php include("errors.php");?> <!--  NOT SHOWING -->

            <script>
                $(document).ready(function(){
                    $('#add-admin-form').on('submit', function(event){
                        event.preventDefault();
                        
                        $.ajax({
                            url: "php_page_contents/add_process/add_admin.php",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "text",
                            success: function(response) {
                                // console.log(response);
                                var adminName = $("#firstname").val() + " " + $("#lastname").val();
                                // Display the success message immediately
                                var add_success = $('#success-message').html("Admin " + adminName + " added successfully.");
                                alertify.success("Admin " + adminName + " added successfully.");
                                console.log("Admin added successfully.");

                                if (add_success) {
                                    // Clear textboxes
                                    $('#lastname').val('');
                                    $('#firstname').val('');
                                    $('#contact').val('');
                                    $('#email').val('');
                                    $('#username').val('');
                                    $('#password').val('');
                                    $('#position').val('');

                                    // Display success message
                                    $('#success-message').html(response.success);
                                    console.log("Cleared Admin Form");
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
                                $('#error-message').html("Error adding an Administrator.");
                                console.log("Error adding an Administrator.");
                            },
                        });
                    });
                });
            </script>

            <script>
                function clearFields() {
                    $('#lastname').val('');
                    $('#firstname').val('');
                    $('#contact').val('');
                    $('#email').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#position').val('');

                    alertify.message('Cleared Administrator Form');
                    console.log("Cleared Administrator Form")
                }
            </script>
        </div>
    </div>

    <!-- Modal for editing -->
    <div id="editModal" class="modal">
        <div class="admin-modal-content">
            <span class="closeEdit" onclick="closeModal('editModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-admin-form">
                <h3>Add Administrator</h3>
                <div class="admin_box">
                    <div class="column_admin">
                        <input type="hidden" id="editAdminId" name="id">
                        <label for="lastname">Last Name:</label><br>
                        <input type="text" class="dp_name" id="edit_lastname" name="lastname" required><br><br>

                        <label for="firstname">First Name:</label><br>
                        <input type="text" class="dp_name" id="edit_firstname" name="firstname" required><br><br>

                        <label for="contact">Contact:</label><br>
                        <input type="text" class="dp_name" id="edit_contact" name="contact" required><br><br>

                        <label for="email">Email:</label><br>
                        <input type="email" class="dp_name" id="edit_email" name="email" required><br><br>

                        <label for="username">Username:</label><br>
                        <input type="text" class="dp_name" id="edit_username" name="username" autocomplete="off" required><br><br>

                        <label for="password">Password:</label><br>
                        <input type="password" class="dp_name" id="edit_password" name="password" autocomplete="off" required>
                        <div class="checkbox-link-container">
                            <div class="checkbox-container">
                                <input type="checkbox" class="checkbox-show-pass" id="show-password-checkbox">
                                <label class="checkbox-label" for="show-password-checkbox">Show Password</label>
                            </div>
                        </div><br>
                        <script>
                            // Get the password input and the show password checkbox
                            const edit_password = document.getElementById('edit_password');
                            const showPasswordCheckbox = document.getElementById('show-password-checkbox');

                            // Add an event listener to the checkbox
                            showPasswordCheckbox.addEventListener('change', function () {
                                // If the checkbox is checked, set the type of the password input to "text"; otherwise, set it to "password"
                                edit_password.type = this.checked ? 'text' : 'password';
                            });
                        </script>

                        <label for="position">Position:</label><span class="optional"> (Optional)</span><br>
                        <input type="text" class="dp_name" id="edit_position" name="position" autocomplete="off" placeholder="default: Administrator" value="Administrator"><br><br>
                    </div>
                </div><br>
                <button type="button" class="btn" id="editSubmitAdmin" onclick="updateRecord()">Update</button>
            </form>
        </div>
    </div>

    <script>
        function editRecord(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_admin.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var record = response.data;
                        if (record) {
                            // console.log(record);
                            // Populate the modal fields with the record data
                            $('#editAdminId').val(record.id);
                            $('#edit_lastname').val(record.admin_lastname);
                            $('#edit_firstname').val(record.admin_firstname);
                            $('#edit_contact').val(record.contact);
                            $('#edit_email').val(record.email);
                            $('#edit_username').val(record.admin_username);
                            $('#edit_password').val(record.admin_pass);
                            $('#edit_position').val(record.position);
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
                var id = $('#editAdminId').val();
                var lastname = $('#edit_lastname').val();
                var firstname = $('#edit_firstname').val();
                var contact = $('#edit_contact').val();
                var email = $('#edit_email').val();
                var username = $('#edit_username').val();
                var password = $('#edit_password').val();
                var position = $('#edit_position').val();

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_admin.php',
                    type: 'POST',
                    data: {
                        id: id,
                        lastname: lastname,
                        firstname: firstname,
                        contact: contact,
                        email: email,
                        username: username,
                        password: password,
                        position: position
                    },
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
                console.log('Record is not defined.');
            }
        }
    </script>
</body>

</html>