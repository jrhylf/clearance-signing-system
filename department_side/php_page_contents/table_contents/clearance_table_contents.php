<?php
include('conn.php');

session_start();
$department = $_SESSION['department'];
?>

<table id="clearedTable" class="flat-table">
    <thead>
        <tr>
            <th>Select</th>
            <th>Student ID</th>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Course</th>
            <th>Section</th>
            <th>Remarks</th>
            <!-- <th>Department</th> -->
        </tr>
    </thead>
    <tbody>
        <?php
        $clearedTable = mysqli_query($db, "SELECT * FROM tbl_students WHERE remarks = 'Cleared' AND department = '$department' ");
        if (mysqli_num_rows($clearedTable) > 0) {
            while ($row = mysqli_fetch_array($clearedTable)) {
                ?>
        <tr>
            <td><input type="checkbox" class="select-checkbox" data-id="<?php echo $row['id']; ?>"></td>
            <td>
                <?php echo $row['student_id'] ?>
            </td>
            <td>
                <?php echo $row['last_name'] ?>
            </td>
            <td>
                <?php echo $row['first_name'] ?>
            </td>
            <td>
                <?php echo $row['course_code'] ?>
            </td>
            <td>
                <?php echo $row['section'] ?>
            </td>
            <td style="color: <?php echo ($row['remarks'] == 'Cleared') ? 'green' : 'red'; ?>">
                <?php echo $row['remarks']; ?>
            </td>
            <!-- <td>
                        <?php echo $row['department'] ?>
                    </td> -->
        </tr>
        <?php
            }
        } else {
            echo '<tr><td colspan="7">No students are currently cleared.</td></tr>';
        }
        ?>
    </tbody>
</table>