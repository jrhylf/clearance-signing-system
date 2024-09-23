<?php
include('conn.php');
?>

<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Admin Username</th>
            <!-- <th>Password</th> -->
            <th>Position</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $departmentTable = mysqli_query($db, "SELECT * FROM tbl_administrator");
            if (mysqli_num_rows($departmentTable) > 0) {
                while ($row = mysqli_fetch_array($departmentTable)) {
        ?>
        <tr>
            <!-- <td><?php // echo $row['id']; ?></td> -->
            <td><?php echo $row['admin_username']; ?></td>
            <!-- <td><?php // echo $row['admin_pass']; ?></td> -->
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['admin_firstname']; ?></td>
            <td><?php echo $row['admin_lastname']; ?></td>
            <td><?php echo $row['contact']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <button type="button" class="admin-edit-btn edit-btn" id="edit_admin_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>

                <?php
                    // Check if admin_firstname or admin_lastname is not equal to 'Administrator'
                    if ($row['admin_firstname'] !== 'Administrator' && $row['admin_lastname'] !== 'Administrator') {
                ?>
                    <button type="button" class="admin-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" data-admin_username="<?php echo $row['admin_username']; ?>">Delete</button>
                <?php
                    }
                ?>
            </td>
        </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4">No current administrators available.</td></tr>';
            }
        ?>
    </tbody>
</table>
