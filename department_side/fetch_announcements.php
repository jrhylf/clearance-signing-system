<?php
include('conn.php');

session_start();
$department = $_SESSION['department'];

$currentDate = date("Y-m-d"); // Get the current date

$announcementTable = mysqli_query($db, "SELECT * FROM tbl_announcements WHERE (announce_for = '$department' OR announce_for = 'Everyone' OR announce_for = 'Departments') AND start_date <= '$currentDate' AND end_date >= '$currentDate'");

if (mysqli_num_rows($announcementTable) > 0) {
    echo '<div class="announcement_content">';
    while ($row = mysqli_fetch_array($announcementTable)) {
        // display the announcements
        echo '<div class="announcement_card">';
        echo '<h5>' . $row['title'] . '</h5>';
        echo '<p class="description">' . $row['description'] . '</p>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="default">No current announcements available.</p>';
}
?>
