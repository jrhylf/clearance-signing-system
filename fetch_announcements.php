<?php include('conn.php');

session_start();
$course = mysqli_real_escape_string($db, $_SESSION['course']); // Sanitize user input

$currentDate = date("Y-m-d"); // Get the current date

$announcementTable = mysqli_query($db, "SELECT * FROM tbl_announcements WHERE (announce_for = '$course' OR announce_for = 'Everyone' OR announce_for = 'Students Only') AND start_date <= '$currentDate' AND end_date >= '$currentDate' ");

if (mysqli_num_rows($announcementTable) > 0) {
    echo '<div class="announcement_content">';
    while ($row = mysqli_fetch_array($announcementTable)) {
        // Use the $row array as needed (e.g., store it in a database, perform other calculations, etc.)
        
        // If you don't need to display the announcement, you can remove the following lines
        echo '<div class="announcement_card">';
        echo '<h5>' . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . '</h5>'; // Sanitize output
        echo '<p class="description">' . htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8') . '</p>'; // Sanitize output
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p class="default">No current announcements available.</p>';
}
?>
