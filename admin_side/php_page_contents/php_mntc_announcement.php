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

    <!-- Scripts for Announcement -->
    <script src="php_page_contents/scripting_processes/delete_announcement_script.js"></script>
</head>

<body onload="announcementTable()">

    <script type="text/javascript">
        function announcementTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("announcementTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/announcement_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            announcementTable();
        }, 1000);
    </script>

    <div class="departments_box">
        <div class="box">
            <button type="button" class="btn" id="add_announcement_modal" onclick="openModal('myModal')">ADD</button>
            <!-- <input type="text" class="search" id="search-user" placeholder="Search Announcement..."> -->
            <h2>Announcements</h2>
            <label>In this module, the admin can add, edit, and delete announcements.</label>
            <div class="table_container" id="announcementTable">
                <!-- Table Records -->

                <script>
                    $(document).ready(function () {
                        $(document).on("click", ".announcement-edit-btn", function () {
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
            <span class="closeEdit" onclick="closeModal('myModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="add-announcement-form">
            <h2>Add Announcement</h2>    
                <div class="column">
                    <label for="title_enter">Title:</label><br>
                    <input type="text" maxlength="300" class="dp_name" id="title_enter" name="titleAnnouncement" required><br>
                </div>
                <label for="title_desc" id="title_margin_left">Description:</label><br>
                <textarea rows="15" cols="20" wrap="soft" maxlength="10000" oninput="countCharacters()" class="thumbnail" id="title_desc" name="descriptionAnnouncement"></textarea><br>
                <span class="char_left_margin_left">Characters left: </span><span id="characters_left"></span><br><br>

                <!-- Count characters left -->
                <script>
                    countCharacters()

                    function countCharacters() {
                        let textArea = document.getElementById("title_desc");
                        let characterCounter = document.getElementById("characters_left");
                        const maxNumOfChars = 10000;

                        const countCharacters = () => {
                            let numOfEnteredChars = textArea.value.length;
                            let counter = maxNumOfChars - numOfEnteredChars;
                            characterCounter.textContent = counter;
                        };

                        textArea.addEventListener("input", countCharacters);
                    }
                </script>
                <!-- Count characters left -->

                <div class="announcement_box">
                    <div class="column_announcement">
                        <label for="section">Announcement For:</label><br>
                        <?php $sections = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <?php $departments = mysqli_query($db, "SELECT department_name FROM tbl_departments"); ?>
                        <select class="announcement_dropdown" id="section" name="announceFor" required>
                            <option value="No Recipient">No Recipient</option>
                            <option value="Everyone">Everyone</option>
                            <option value="All Departments">All Departments</option>
                            <?php while ($row = mysqli_fetch_array($departments)) { ?>
                                <option>
                                    <?php echo ($row['department_name']); ?>
                                </option>
                            <?php } ?>
                            <option value="Students Only">Students Only</option>
                            <?php while ($row = mysqli_fetch_array($sections)) { ?>
                                <option>
                                    <?php echo ($row['course_code']); ?>
                                </option>
                            <?php } ?>
                        </select><br><br>
                    </div>

                    <div class="column_announcement">
                        <label for="start_date">Start Date:</label><br>
                        <input type="date" class="dp_name" id="start_date" value="<?php echo date('Y-m-d'); ?>" name="startDate" required><br><br>
                        <input type="time" class="dp_name" id="start_time" value="08:00:00" name="startTime" hidden>
                    </div>

                    <div class="column_announcement">
                        <label for="end_date">End Date:</label><br>
                        <input type="date" class="dp_name" id="end_date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" name="endDate" required><br><br>
                        <input type="time" class="dp_name" id="end_time" value="16:00:00" name="endTime" hidden>
                    </div>
                </div>

                <!-- THUMBNAIL SELECT IMAGE -->
                <label for="thumbnail" id="title_margin_left">Thumbnail:</label><br>
                <input type="file" accept="image/png, image/jpeg" class="thumbnail" id="thumbnail" name="image">
                <button type="button" class="btn" id="btn_clear_dept" onclick="removeimage()">Remove Image</button><br><br>

                <button type="submit" class="btn" id="btn_add_student" name="add_announcement">ADD</button>
                <button type="button" class="btn" id="btn_clear_announcement" onclick="clearFields()">CLEAR FORM</button>
            </form>

            <div id="success-message" style="color: green;"></div>
            <div id="error-message" style="color: red;"></div>

            <script>
                // DONE January 12, 2024
                $(document).ready(function () {
                    $('#add-announcement-form').on('submit', function (event) {
                        event.preventDefault();
                        $.ajax({
                            url: "php_page_contents/add_process/add_announcement.php",
                            method: "POST",
                            data: new FormData(this),
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                console.log("Success Response:", response);

                                if (response && response.hasOwnProperty("status")) {
                                    if (response.status === "success") {
                                        alertify.success(response.message);
                                        console.log(response.message);

                                        // Close the modal
                                        closeModal('myModal');

                                        // Refresh the table
                                        announcementTable();
                                    } else if (response.status === 'error') {
                                        alertify.error(response.message);
                                        console.log(response.message);
                                    }
                                } else {
                                    console.error("Invalid response structure. Missing 'status' key.");
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("AJAX Error:", xhr.responseText);

                                // Display a generic error message
                                alertify.error("Error adding an Announcement.");
                            },
                        });
                    });
                });
            </script>
        </div>
    </div>

    <script type="text/javascript">
        function clearFields() {
            $('#title_enter').val('');
            $('#title_desc').val('');
            $('#section').val('No Recipient');
            // ? Should I clear the date and time fields?
            // $('#start_date').val('');
            // $('#start_time').val('');
            // $('#end_date').val('');
            // $('#end_time').val('');
            alertify.message('Cleared Announcement Form');
            console.log("Cleared Announcement Form");
        }

        function removeimage() {
            $('#thumbnail').val('');
            $('#edit_thumbnail').val('');
            alertify.message('Image Removed');
            console.log("Image Removed");
        }
    </script>

    <!-- Modal for Editing -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="closeEdit" onclick="closeModal('editModal')">&times;</span>
            <!-- Your existing HTML content here -->
            <form id="edit-announcement-form">
            <h2>Edit Announcement</h2>   
                <input type="hidden" id="editAnnouncementId" name="id"> 
                <div class="column">
                    <label for="edit_title_enter">Title:</label><br>
                    <input type="text" maxlength="300" class="dp_name" id="edit_title_enter" name="titleAnnouncement" required><br>
                </div>
                <label for="edit_title_desc" id="title_margin_left">Description:</label><br>
                <textarea rows="15" cols="20" wrap="soft" maxlength="10000" oninput="countCharacters()" class="edit_title_desc" id="edit_title_desc" name="descriptionAnnouncement"></textarea><br>
                <span class="char_left_margin_left">Characters left: </span><span id="edit_characters_left"></span><br><br>

                <!-- Count characters left -->
                <script>
                    countCharacters()

                    function countCharacters() {
                        let textArea = document.getElementById("edit_title_enter");
                        let characterCounter = document.getElementById("edit_characters_left");
                        const maxNumOfChars = 10000;

                        const countCharacters = () => {
                            let numOfEnteredChars = textArea.value.length;
                            let counter = maxNumOfChars - numOfEnteredChars;
                            characterCounter.textContent = counter;
                        };

                        textArea.addEventListener("input", countCharacters);
                    }
                </script>
                <!-- Count characters left -->

                <div class="announcement_box">
                    <div class="column_announcement">
                        <label for="edit_section">Announcement For:</label><br>
                        <?php $sections = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <?php $departments = mysqli_query($db, "SELECT department_name FROM tbl_departments"); ?>
                        <select class="announcement_dropdown" id="edit_section" name="announceFor" required>
                            <option value="No Recipient">No Recipient</option>
                            <option value="Everyone">Everyone</option>
                            <option value="All Departments">All Departments</option>
                            <?php while ($row = mysqli_fetch_array($departments)) { ?>
                                <option>
                                    <?php echo ($row['department_name']); ?>
                                </option>
                            <?php } ?>
                            <option value="Students Only">Students Only</option>
                            <?php while ($row = mysqli_fetch_array($sections)) { ?>
                                <option>
                                    <?php echo ($row['course_code']); ?>
                                </option>
                            <?php } ?>
                        </select><br><br>
                    </div>

                    <div class="column_announcement">
                        <label for="edit_start_date">Start Date:</label><br>
                        <input type="date" class="dp_name" id="edit_start_date" value="<?php echo date('Y-m-d'); ?>" name="startDate" required><br><br>
                        <input type="time" class="dp_name" id="edit_start_time" value="08:00:00" name="startTime" hidden>
                    </div>

                    <div class="column_announcement">
                        <label for="edit_end_date">End Date:</label><br>
                        <input type="date" class="dp_name" id="edit_end_date" value="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" name="endDate" required><br><br>
                        <input type="time" class="dp_name" id="edit_end_time" value="16:00:00" name="endTime" hidden>
                    </div>
                </div>

                <!-- THUMBNAIL SELECT IMAGE -->
                <label for="edit_thumbnail" id="title_margin_left">Thumbnail:</label><br>
                <input type="file" accept="image/png, image/jpeg" class="thumbnail" id="edit_thumbnail" name="image">
                <button type="button" class="btn" id="btn_clear_dept" onclick="removeimage()">Remove Image</button><br><br>

                <button type="button" class="btn" id="editSubmit" onclick="updateRecord()">Update</button>
                <!-- <button type="button" class="btn" id="btn_cancel" onclick="clearFields()">Cancel Editing</button> -->
            </form>
        </div>
    </div>

    <script>
        function editRecord(recordId) {
            $.ajax({
                url: 'php_page_contents/edit_process/fetch_announcement.php',
                type: 'POST',
                data: { id: recordId },
                dataType: 'json',
                success: function (response) {
                    if (response && response.hasOwnProperty('data')) {
                        var record = response.data;
                        console.log(record);
                        // Populate the modal fields with the record data
                        $('#editAnnouncementId').val(record.id);
                        $('#edit_title_enter').val(record.title);
                        $('#edit_title_desc').val(record.description);
                        $('#edit_section').val(record.announce_for);
                        $('#edit_start_date').val(record.start_date);
                        $('#edit_start_time').val(record.start_time);
                        $('#edit_end_date').val(record.end_date);
                        $('#edit_end_time').val(record.end_time);
                        $('#edit_thumbnail').val(record.image);
                        // Save the record for later use
                        window.record = record;
                        // Show the modal
                        $('#editModal').modal('show');
                    } else {
                        alertify.error('Error fetching record. Data not available.');
                        console.log('Error fetching record. Data not available.');
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
                var id = $('#editAnnouncementId').val();
                var title = $('#edit_title_enter').val();
                var description = $('#edit_title_desc').val();
                var announce_for = $('#edit_section').val();
                var start_date = $('#edit_start_date').val();
                var start_time = $('#edit_start_time').val();
                var end_date = $('#edit_end_date').val();
                var end_time = $('#edit_end_time').val();
                var image = $('#edit_thumbnail').val();

                // Optional: Check for empty image field and handle accordingly
                // For example, set image to null or skip it in the data object

                $.ajax({
                    url: 'php_page_contents/edit_process/edit_announcement.php',
                    type: 'POST',
                    data: { id: id, title: title, description: description, announce_for: announce_for, start_date: start_date, start_time: start_time, end_date: end_date, end_time: end_time, image: image },
                    dataType: 'json',
                    success: function (response) {
                        // Polished AJAX MESSAGES
                        if (response.status === 'success') {
                            // Handle success, e.g., close the modal, refresh the page, etc.
                            alertify.success(response.message);
                            console.log(response.message) 
                            $('#editModal').modal('hide');
                        } else if (response.status === 'error') {
                            alertify.error(response.message);
                            console.log(response.message);
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