<?php include('conn.php'); ?>
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
    <!-- <script src="php_page_contents/scripting_processes/add_user_script.js"></script> -->
    <script src="php_page_contents/scripting_processes/delete_user_script.js"></script>
    <!-- <script src="php_page_contents/scripting_processes/edit_user_script.js"></script> -->
</head>

<body onload="usersTable()">

    <script type="text/javascript">
        function usersTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("usersTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/users_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            usersTable();
        }, 1000);
    </script>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_users_modal" onclick="openModal('myModal')">ADD</button>
            <input type="text" class="search" id="search-user" placeholder="Search User...">
            <h2>Users</h2>
            <label>In this module, the admin can add, edit, delete a user.</label>
            <div class="table_container" id="usersTable">
                <!-- Table Records -->

                <!-- Script for Edit Button multiple functions. -->
                <script>
                    $(document).ready(function () {
                        $(document).on("click", ".users-edit-btn", function () {
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
            <form id="add-users-form">
                <h3>Add User</h3>
                <div class="departments_box">
                    <div class="column">
                        <label for="lastname">Last Name:</label><br>
                        <input type="text" class="dp_name" id="lastname" name="lastname" required><br><br>

                        <label for="firstname">First Name:</label><br>
                        <input type="text" class="dp_name" id="firstname" name="firstname" required><br><br>

                        <label for="middlename">Middle Name:</label><br>
                        <input type="text" class="dp_name" id="middlename" name="middlename">
                    </div>

                    <div class="column">
                        <label for="gender">Gender:</label><br>
                        <select class="dp_dropdown" id="gender" name="gender" required>
                            <option>-Select Gender-</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select><br><br>

                        <label for="age">Age:</label><br>
                        <input type="text" class="dp_name" id="age" name="age" required><br><br>

                        <label for="email">Email:</label><br>
                        <input type="email" class="dp_name" id="email" name="email" required>
                    </div>

                    <div class="column">
                        <label for="contact">Contact:</label><br>
                        <input type="text" class="dp_name" id="contact" name="contact" required><br><br>

                        <label for="username">Username:</label><br>
                        <input type="text" class="dp_name" id="username" name="username" autocomplete="off" required><br><br>

                        <label for="password">Password:</label><br>
                        <input type="password" class="dp_name" id="password" name="password" autocomplete="off" required>
                    </div>

                    <div class="column">
                        <label for="department_dd">Department:</label><br>
                        <?php $departments = mysqli_query($db, "SELECT department_name FROM tbl_departments"); ?>
                        <select class="dp_dropdown" id="department_dd" name="department_assigned">
                            <option>No Department</option>
                            <?php while ($row = mysqli_fetch_array($departments)) { ?>
                                <option>
                                    <?php echo $row['department_name'] ?>
                                </option>
                            <?php } ?>
                        </select><br><br>

                        <label for="position">Position:</label><br>
                        <input type="text" class="dp_name" id="position" name="position" autocomplete="off" placeholder="e.g. Head, Assistant" value="No Position" required>
                    </div>
                </div><br>
                <button type="submit" class="btn" name="add_User" id="add-user-btn">ADD</button>
                <button type="button" class="btn" id="btn_clear_dept" onclick="clearFields()">CLEAR</button>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>

            <script>
                $(document).ready(function(){
                    $('#add-users-form').on('submit', function(event){
                        event.preventDefault();
                        $.ajax({
                            url: "php_page_contents/add_process/add_users.php",
                            method: "POST",
                            data: $(this).serialize(),
                            dataType: "text",
                            success: function(response) {
                                var userName = $("#firstname").val() + " " + $("#lastname").val();
                                // Display the success message immediately
                                var add_success = $('#success-message').html("User " + userName + " added successfully.");
                                alertify.success("User " + userName + " added successfully.");
                                console.log("User added successfully.");

                                if (add_success) {
                                    // Clear textboxes
                                    $('#lastname').val('');
                                    $('#firstname').val('');
                                    $('#middlename').val('');
                                    $('#gender').val('-Select Gender-');
                                    $('#department_dd').val('No Department');
                                    $('#age').val('');
                                    $('#username').val('');
                                    $('#password').val('');
                                    $('#email').val('');
                                    $('#contact').val('');

                                    // Display success message
                                    $('#success-message').html(response.success);

                                    console.log("Cleared User");
                                } else {
                                    // Display error message
                                    $('#error-message').html(response.error);
                                    console.log("Not Cleared User");
                                }

                                // Add a delay (e.g., 3 seconds) before fading out and clearing the success message
                                setTimeout(function() {
                                    $('#success-message').fadeOut(1000, function() {
                                        // Animation complete, clear the success message
                                        $('#success-message').html("");
                                    });
                                }, 3000); // 3000 milliseconds = 3 seconds
                            },

                            error: function () {
                                $("#error-message").html("Error adding a User.");
                                console.log("Error adding a User.");
                            },
                        });
                    });
                });
            </script>

            <script>
                function clearFields() {
                    $('#lastname').val('');
                    $('#firstname').val('');
                    $('#middlename').val('');
                    $('#gender').val('-Select Gender-');
                    $('#department_dd').val('No Department');
                    $('#age').val('');
                    $('#username').val('');
                    $('#password').val('');
                    $('#email').val('');
                    $('#contact').val('');

                    console.log("Cleared Users Form")
                }
            </script>
        </div>
    </div>

    <!-- Modal for Editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="closeEdit" onclick="closeModal('editModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-users-form">
                <h3>Edit User</h3>
                <div class="departments_box">
                    <div class="column">
                        <input type="hidden" id="editUsersId" name="id">

                        <label for="editLastname">Last Name:</label><br>
                        <input type="text" class="dp_name" id="editLastname" name="lastname" required><br><br>

                        <label for="editFirstname">First Name:</label><br>
                        <input type="text" class="dp_name" id="editFirstname" name="firstname" required><br><br>

                        <label for="editMiddlename">Middle Name:</label><br>
                        <input type="text" class="dp_name" id="editMiddlename" name="middlename">
                    </div>

                    <div class="column">
                        <label for="editGender">Gender:</label><br>
                        <select class="dp_dropdown" id="editGender" name="gender" required>
                            <option>-Select Gender-</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select><br><br>

                        <label for="editAge">Age:</label><br>
                        <input type="text" class="dp_name" id="editAge" name="age" required><br><br>

                        <label for="editEmail">Email:</label><br>
                        <input type="email" class="dp_name" id="editEmail" name="email" required>
                    </div>

                    <div class="column">
                        <label for="editContact">Contact:</label><br>
                        <input type="text" class="dp_name" id="editContact" name="contact" required><br><br>

                        <label for="editUsername">Username:</label><br>
                        <input type="text" class="dp_name" id="editUsername" name="username" autocomplete="off" required><br><br>

                        <label for="editPassword">Password:</label><br>
                        <input type="password" class="dp_name" id="editPassword" name="password" autocomplete="off" required>
                    </div>

                    <div class="column">
                        <label for="editDepartment_dd">Department:</label><br>
                        <?php $departments = mysqli_query($db, "SELECT department_name FROM tbl_departments"); ?>
                        <select class="dp_dropdown" id="editDepartment_dd" name="department_assigned">
                            <option>No Department</option>
                            <?php while ($row = mysqli_fetch_array($departments)) { ?>
                                <option>
                                    <?php echo $row['department_name'] ?>
                                </option>
                            <?php } ?>
                        </select><br><br>

                        <label for="editPosition">Position:</label><br>
                        <input type="text" class="dp_name" id="editPosition" name="position" autocomplete="off" placeholder="e.g. Head, Assistant" required>
                    </div>
                </div><br>
                <button type="button" class="btn" id="editSubmit" onclick="updateRecord()">Update</button>
            </form>
        </div>
    </div>

    <script>
        function editRecord(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_user.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var record = response.data;
                        if (record) {
                            // console.log(record);
                            // Populate the modal fields with the record data
                            $('#editUsersId').val(record.id);
                            $('#editLastname').val(record.last_name);
                            $('#editFirstname').val(record.first_name);
                            $('#editMiddlename').val(record.middle_name);
                            $('#editGender').val(record.gender);
                            $('#editAge').val(record.age);
                            $('#editEmail').val(record.email);
                            $('#editContact').val(record.contact);
                            $('#editUsername').val(record.user_username);
                            $('#editPassword').val(record.user_password);
                            $('#editDepartment_dd').val(record.department_assigned);
                            $('#editPosition').val(record.position);
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
                var id = $('#editUsersId').val();
                var lastname = $('#editLastname').val();
                var firstname = $('#editFirstname').val();
                var middlename = $('#editMiddlename').val();
                var gender = $('#editGender').val();
                var age = $('#editAge').val();
                var email = $('#editEmail').val();
                var contact = $('#editContact').val();
                var username = $('#editUsername').val();
                var password = $('#editPassword').val();
                var department_assigned = $('#editDepartment_dd').val();
                var position = $('#editPosition').val();

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_user.php',
                    type: 'POST',
                    data: {
                        id: id,
                        lastname: lastname,
                        firstname: firstname,
                        middlename: middlename,
                        gender: gender,
                        age: age,
                        email: email,
                        contact: contact,
                        username: username,
                        password: password,
                        department_assigned: department_assigned,
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

    <!-- <script src="/js/input_restriction.js"></script> -->
</body>

</html>