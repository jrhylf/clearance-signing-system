<?php
// Database connection
include('conn.php');

// Select the latest 3 activity records ordered by ID
$activityTable = mysqli_query($db, "SELECT * FROM tbl_activity ORDER BY id DESC LIMIT 3");

if (mysqli_num_rows($activityTable) > 0) {
    // Generate and return the updated content
    while ($row = mysqli_fetch_array($activityTable)) {
        echo '<h5>' . $row['department_name'] . ' | ' . $row['user'] . '</h5>';
        echo '<p class="description">' . $row['activity'] . '</p>';
    }
} else {
    echo '<p>No current activities available.</p>';
}
?>
