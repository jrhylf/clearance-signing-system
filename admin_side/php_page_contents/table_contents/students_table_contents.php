<?php
include('conn.php');
?>

<table id="myTable" class="flat-table">
    <thead>
        <tr>
            <th>Status</th>
            <th>Student ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Gender</th>
            <th>Section</th>
            <th>Email</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $studentsTable = mysqli_query($db, "SELECT * FROM tbl_students ORDER BY last_name");
            if (mysqli_num_rows($studentsTable) > 0) {
                while ($row = mysqli_fetch_array($studentsTable)) {
        ?>
        <tr>
            <!-- // TODO: "OK" SHOULD IGNORE CASE
                // TODO: STATUS SHOULD BE BASED ON THE STUDENT'S CLEARANCE STATUS (e.g. 2x2, 1x1, Form 137, etc.)
            -->
            <td style="color: <?php echo ($row['status'] == 'OK') ? 'green' : 'red'; ?>"><?php echo $row['status']; ?></td>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['last_name']; ?></td>
            <td><?php echo $row['first_name']; ?></td>
            <td><?php echo $row['middle_name']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['course'] . ' ' . $row['section']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <!-- // TODO REPLACE "TYPE" DEPENDING ON ACTIVITY(e.g. Active, Alumni, Returnee) -->
            <td style="color: <?php echo ($row['type'] == 'Active') ? 'green' : 'red'; ?>"><?php echo $row['type']; ?></td>
            <td>
                <button type="button" class="student-edit-btn edit-btn" id="edit_student_modal" data-id="<?php echo $row['id']; ?>" onclick="openModal('editModal')">Edit</button>
                <button type="button" class="student-delete-btn delete_btn" data-id="<?php echo $row['id']; ?>" onclick="console.log('Delete Button')">Delete</button>
            </td>
        </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="10">No current students available.</td></tr>';
            }
        ?>
    </tbody>
</table>

<!-- <script>
    $(document).ready(function () {
        const table = $('#myTable').DataTable(); 

        // Add an event listener to the input field
        $('#search-student').on('keyup', function () {
            table.search(this.value).draw();
            console.log("search is working");
        });
    });
</script> -->