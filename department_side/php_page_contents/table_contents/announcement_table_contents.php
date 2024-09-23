<?php
include('conn.php');
$rows = mysqli_query($db, "SELECT * FROM tbl_announcements");
?>
<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Title</th>
            <th>Description</th>
            <th>Announcement For</th>
            <th>Start Date</th>
            <!-- <th>Start Time</th> -->
            <th>End Date</th>
            <!-- <th>End Time</th> -->
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $announcementTable = mysqli_query($db, "SELECT * FROM tbl_announcements");
            if (mysqli_num_rows($announcementTable) > 0) {
                while ($row = mysqli_fetch_array($announcementTable)) {
        ?>
                    <tr>
                        <!-- <td><?php // echo $row['id']; ?></td> -->
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td style="color: <?php echo ($row['announce_for'] == 'No Recipient') ? 'red' : 'black'; ?>"><?php echo $row['announce_for']; ?></td>
                        <td><?php echo $row['start_date']; ?></td>
                        <!-- <td><?php // echo $row['start_time']; ?></td> -->
                        <td><?php echo $row['end_date']; ?></td>
                        <!-- <td><?php // echo $row['end_time']; ?></td> -->
                        <td><?php echo $row['image']; ?></td>
                        <td>
                            <button type="button" class="announcement-edit-btn edit-btn" id="edit_announcement_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>
                            <button type="button" class="announcement-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" onclick="console.log('Delete Button')">Delete</button>
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="9">No current announcements available.</td></tr>';
            }
        ?>
    </tbody>
</table>