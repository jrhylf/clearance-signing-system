<?php
include('conn.php');
$rows = mysqli_query($db, "SELECT * FROM tbl_section");
?>

<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Course Code</th>
            <th>Section Number</th>
            <th>Section</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $sectionTable = mysqli_query($db, "SELECT * FROM tbl_section ORDER BY section");
            if (mysqli_num_rows($sectionTable) > 0) {
                while ($row = mysqli_fetch_array($sectionTable)) {
        ?>
                    <tr>
                        <!-- <td><?php // echo $row['id']; ?></td> -->
                        <td><?php echo $row['course_code'] ?></td>
                        <td><?php echo $row['section_number']; ?></td>
                        <td><?php echo $row['section']; ?></td>
                        <td>
                        <button type="button" class="section-edit-btn edit-btn" id="edit_section_modal" data-id="<?php echo $row['id']; ?>" onclick="openEditModal('editModal')">Edit</button>
                            <button type="button" class="section-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4">No current sections available.</td></tr>';
            }
        ?>
    </tbody>
</table>