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
            <h2>Announcements</h2>
            <label>In this module, the admin can add, edit, and delete announcements.</label>
            <div class="table_container">
                <table class="flat-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Announcement For</th>
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Date</th>
                            <th>End Time</th>
                            <th>Thumbnail</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php // $announcementTable = mysqli_query($db, "SELECT * FROM tbl_announcements"); ?>
                        <?php // while ($row = mysqli_fetch_array($announcementTable)) { ?>
                            <tr>
                                <td><?php // echo $row['id']; ?></td>
                                <td><?php // echo $row['title']; ?></td>
                                <td><?php // echo $row['description']; ?></td>
                                <td><?php // echo $row['announce_for']; ?></td>
                                <td><?php // echo $row['start_date']; ?></td>
                                <td><?php // echo $row['start_time']; ?></td>
                                <td><?php // echo $row['end_date']; ?></td>
                                <td><?php // echo $row['end_time']; ?></td>
                                <td><?php // echo $row['thumbnail']; ?></td>
                                <td>
                                    <button class="edit-btn">Edit</button>
                                    <button class="delete-btn" onclick="deleteAnnouncement(<?php // echo $row['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php // } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

    <!-- <div class="departments_box">
        <div class="card">
            <h2>Add Announcement</h2>
            <?php // include('errors.php'); ?>
            <?php // include('successPrompt.php'); ?>
            <form action="php_page_contents/php_mntc_announcement.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="column">
                    <label for="title-enter">Title:</label><br>
                    <input type="text" maxlength="300" class="dp_name" id="title_enter" name="titleAnnouncement"><br>
                </div>
                <label for="title_desc" id="title_margin_left">Description:</label><br>
                <textarea rows="15" cols="20" wrap="soft" maxlength="5000" oninput="countCharacters()" class="thumbnail" id="title_desc" name="descriptionAnnouncement"></textarea><br>
                <span class="char_left_margin_left">Characters left: </span><span id="characters_left"></span><br><br>

                Count characters left
                <script>
                    countCharacters()

                    function countCharacters() {
                        var textarea = document.getElementById('title_desc');
                        var charCount = document.getElementById('characters_left');

                        var remainingChars = 5000 - textarea.value.length; // Change 100 to your desired character limit
                        charCount.innerText = remainingChars;
                    }
                </script>
                Count characters left

                <div class="departments_box">
                    <div class="column">
                        <label for="dp_name">Announcement For:</label><br>
                        <?php // $sections = mysqli_query($db, "SELECT course_code FROM tbl_courses"); ?>
                        <select class="dp_dropdown" id="section" name="section">
                            <option value="-Select Recipient-">-Select Recipient-</option>
                            <option value="Everyone">Everyone</option>
                            <option value="Departments">Departments</option>
                            <option value="Students Only">Students Only</option>
                            <?php // while ($row = mysqli_fetch_array($sections)) { ?>
                                <option value="<?php // echo ($row['course_code']); ?>">
                                    <?php // echo ($row['course_code']); ?>
                                </option>
                            <?php // } ?>
                        </select><br><br>
                    </div>

                    <div class="column">
                        <label for="dp_name">Start Date & Time:</label><br>
                        <input type="date" class="dp_name" id="dp_name" value="<?php // echo date('Y-m-d'); ?>" name="startDate"><br><br>
                        Current Date
                        <input type="time" class="dp_name" id="dp_name" value="08:00:00" name="startTime">
                    </div>

                    <div class="column">
                        <label for="dp_name">End Date & Time:</label><br>
                        <input type="date" class="dp_name" id="dp_name" value="<?php // echo date('Y-m-d', strtotime('+1 day')); ?>" name="endDate"><br><br>
                        <input type="time" class="dp_name" id="dp_name" value="16:00:00" name="endTime">
                    </div>
                </div>

                THUMBNAIL SELECT IMAGE
                <label for="thumbnail" id="title_margin_left">Thumbnail:</label><br>
                <input type="file" accept="image/png, image/jpeg" class="thumbnail" id="thumbnail" name="thumbnail"><br>

                <button type="submit" class="btn" id="btn_add_student" name="add_announcement">ADD</button>
                <button type="submit" class="btn" id="btn_clear_student">CLEAR</button>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function deleteAnnouncement(delID) {
            if (confirm("Are you sure you want to delete this announcement?")) {
                window.location.href = 'php_page_contents/delete_process_mntc.php?delAnnouncement=' + delID;
            }
        }
    </script> -->

    <!-- <script src="js/input_restriction.js"></script> -->


    // TODO: REMARKS PER STUDENT or BATCH UPLOAD ATA TO ANG ALAM KO. ALSO UI NG TABLE OR SOMETHING. CAN EDIT ONLY NG STUDENT.
    // DI BA TO PWEDE SA CLEARANCE MODULE NA LANG PARA SAMA SAMA? I MEAN PARA MAGKASAMA NA SA IISANG TABLE.
</body>

</html>