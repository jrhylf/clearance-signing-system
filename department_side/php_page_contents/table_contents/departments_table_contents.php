<?php
include('conn.php');
?>

<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Department Name</th>
            <th>User</th>
            <th>Applicable Course</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $departmentTable = mysqli_query($db, "SELECT * FROM tbl_departments");
            if (mysqli_num_rows($departmentTable) > 0) {
                while ($row = mysqli_fetch_array($departmentTable)) {
        ?>
        <tr>
            <!-- <td><?php // echo $row['id']; ?></td> -->
            <td><?php echo $row['department_name']; ?></td>
            <td style="color: <?php echo ($row['user'] == 'No User') ? 'red' : 'black'; ?>"><?php echo $row['user']; ?></td> <!-- // TODO: Dapat lahat ng may kaparehas na department magshow sa User column -->
            <td><?php echo $row['applicable_course']; ?></td>
            <td>
                <button type="button" class="dept-edit-btn edit-btn" id="edit_department_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>
                <button type="button" class="dept-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" data-department_name="<?php echo $row['department_name']; ?>">Delete</button>
            </td>
        </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4">No current departments available.</td></tr>';
            }
        ?>
    </tbody>
</table>