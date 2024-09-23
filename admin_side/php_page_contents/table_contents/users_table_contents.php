<?php
include('conn.php');
$rows = mysqli_query($db, "SELECT * FROM tbl_users");
?>
<table class="flat-table">
    <thead>
        <tr>
            <th>Full Name</th>
            <!-- <th>Gender</th> -->
            <th>Department Assigned</th>
            <th>Position</th>
            <th>Username</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $usersTable = mysqli_query($db, "SELECT * FROM tbl_users ORDER BY last_name");
            if (mysqli_num_rows($usersTable) > 0) {
                while ($row = mysqli_fetch_array($usersTable)) {
        ?>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                        <td style="color: <?php echo ($row['department_assigned'] == 'No Department') ? 'red' : 'black'; ?>"><?php echo $row['department_assigned']; ?></td>
                        <td style="color: <?php echo ($row['position'] == 'No Position') ? 'red' : 'black'; ?>"><?php echo $row['position']; ?></td>
                        <td><?php echo $row['user_username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td>
                            <button type="button" class="users-edit-btn edit-btn" id="edit_users_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>
                            <button type="button" class="user-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" onclick="console.log('Delete Button')">Delete</button>
                        </td>
                    </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="7">No current users available.</td></tr>';
            }
        ?>
    </tbody>
</table>