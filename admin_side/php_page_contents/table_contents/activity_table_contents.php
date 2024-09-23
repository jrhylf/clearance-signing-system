<?php
include('conn.php');
$rows = mysqli_query($db, "SELECT * FROM tbl_activity");
?>
<table class="flat-table">
    <thead>
        <tr>
            <!-- <th>ID</th> -->
            <th>Date</th>
            <th>Time</th>
            <th>User</th>
            <th>Department Name</th>
            <th>Activity</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $activityTable = mysqli_query($db, "SELECT * FROM tbl_activity ORDER BY id DESC");
            if (mysqli_num_rows($activityTable) > 0) {
                while ($row = mysqli_fetch_array($activityTable)) {
        ?>
                    <tr>
                        <!-- <td><?php //  echo $row['id']; ?></td> -->
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['time']; ?></td>
                        <td><?php echo $row['user']; ?></td>
                        <td><?php echo $row['department_name']; ?></td>
                        <td><?php echo $row['activity']; ?></td>
                    </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4">No current activities today.</td></tr>';
            }
        ?>
    </tbody>
</table>