<?php
include('conn.php');
$rows = mysqli_query($db, "SELECT * FROM tbl_courses");
?>

<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Course Code</th>
            <th>Course Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $courseTable = mysqli_query($db, "SELECT * FROM tbl_courses ORDER BY id DESC");
            if (mysqli_num_rows($courseTable) > 0) {
                while ($row = mysqli_fetch_array($courseTable)) { 
        ?>
                    <tr>
                        <!-- <td><?php // echo $row['id']; ?></td> -->
                        <td><?php echo $row['course_code'] ?></td>
                        <td><?php echo $row['course_description']; ?></td>
                        <td>
                            <button type="button" class="course-edit-btn edit-btn" id="edit_course_modal" data-id="<?php echo $row['id']; ?>" onclick="openEditModal('editModal')">Edit</button>
                            <button type="button" class="course-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="3">No current courses available.</td></tr>';
            }
        ?>
    </tbody>
</table>