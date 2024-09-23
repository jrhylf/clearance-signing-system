<?php include('conn.php') ?>
<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location:loginPage.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STUDENT | Clearance Signing System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/127fba62e2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/mainPage.css">
    <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap-grid.css"> -->
    <link rel="shortcut icon" href="images/STI LOGO.png" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <div class="yellow"></div>
        <div class="blue">
            <span class="header_text">WELCOME <span id="user-name"><?php echo $_SESSION['student_name']; ?></span></span>
        </div>
    </header>

    <main>
        <div class="main">
            <div class="nav_bar">
                <ul>
                    <li>
                    <a href="mainPage.php?page=dashboard" class="nav_options">
                            <i class='bx bxs-dashboard'><span class="side_menu"> Dashboard</span></i>
                        </a>
                    </li>
                    <li>
                        <a href="mainPage.php?page=qrcode" class="nav_options">
                            <i class='bx bx-qr'><span class="side_menu"> QR Code</span></i>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="nav_options" id="logout-btn">
                            <i class='bx bxs-log-out'> Logout</i>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="main_content">
            <div class="sy_sem_box">
                    <div class="box_SY">
                        <div class="column">
                            <img src="images/calendar.png" class="top_box_icon1" alt="calendar" style="width: 50px; height: 50px;">
                        </div>
                        <div class="column">
                            <h4 class="sy_sem">School Year</h4>
                            <span class="top_box_labels">
                                <span">
                                    <?php
                                        $class_start_result = mysqli_query($db, "SELECT sy_start, sy_end FROM tbl_sy_sem WHERE status = 'Active' ");
                                        
                                        // Fetch the first row outside the loop
                                        $class_start_row = mysqli_fetch_assoc($class_start_result);
                                        $class_start_month = $class_start_row['sy_start'];
                                        $class_end_month = $class_start_row['sy_end'];
                                        echo $class_start_month . "-" . $class_end_month;
                                        
                                        // Fetch the remaining rows inside the loop
                                        while ($row = mysqli_fetch_assoc($class_start_result)) {
                                            $class_start_month = $row['sy_start'];
                                            $class_end_month = $row['sy_end'];
                                            echo $class_start_month . "-" . $class_end_month;
                                        }
                                    ?>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="box_SEM">
                        <div class="column">
                            <img src="images/book.png" class="top_box_icon2" alt="books" style="width: 50px; height: 50px;">
                        </div>
                        <div class="column">
                            <h4 class="sy_sem">Semester</h4>
                            <span class="top_box_labels">
                                <?php
                                    $class_start_result = mysqli_query($db, "SELECT semester FROM tbl_sy_sem WHERE status = 'Active' ");

                                    // Fetch the first row outside the loop
                                    $class_start_row = mysqli_fetch_assoc($class_start_result);
                                    $class_start_semester = $class_start_row['semester'];

                                    // Check the semester and echo accordingly
                                    if ($class_start_semester == 1) {
                                        echo $class_start_semester . "st Semester";
                                    } elseif ($class_start_semester == 2) {
                                        echo $class_start_semester . "nd Semester";
                                    } else {
                                        echo "Invalid semester"; // You can customize this message based on your needs
                                    }

                                    // Fetch the remaining rows inside the loop
                                    while ($row = mysqli_fetch_assoc($class_start_result)) {
                                        $class_start_semester = $row['semester'];

                                        // Check the semester and echo accordingly
                                        if ($class_start_semester == 1) {
                                            echo $class_start_semester . "st Semester";
                                        } elseif ($class_start_semester == 2) {
                                            echo $class_start_semester . "nd Semester";
                                        } else {
                                            echo "Invalid semester"; // You can customize this message based on your needs
                                        }
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <br>
                <hr><br>
                <div class="main_php_contents">
                    <?php
                    // Determine which page to display based on the 'page' parameter in the URL
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];

                        if ($page == 'dashboard') {
                            include 'php_page_contents/php_dashboard.php';
                        } else if ($page == 'qrcode') {
                            include 'php_page_contents/php_qrcode.php';
                        }
                    } else {
                        // Default to displaying 'dashboard'
                        include 'php_page_contents/php_dashboard.php';
                    }
                    ?>
                </div>
            </div>

            <div class="rightContent">
                <div class="titleBG">
                    <p class="titleText">Announcements</p>
                </div>

                <div id="announcements" class="announcements">
                    <div class="announcement_content">
                        <!-- Content will be updated by the JavaScript function -->
                    </div>
                </div>

                <script>
                    function updateAnnouncements() {
                        var announcementsContainer = document.getElementById('announcements');
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'fetch_announcements.php', true);

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === 4 && xhr.status === 200) {
                                announcementsContainer.innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send();
                    }

                    // Call the function initially
                    updateAnnouncements();

                    // Set an interval to call the function every 1.5 second
                    setInterval(updateAnnouncements, 1500); // 1500 milliseconds = 1.5 second
                </script>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer">
            <a href="https://sti.edu/" class="stiOfficial">STI College Official Website</a>

            <h3 class="socials">Socials</h3>
            <a href="https://web.facebook.com/alabang.sti.edu" class="social_links"><i class="fa-brands fa-facebook"></i><span> STI College Alabang</span></a>
            <a href="https://www.instagram.com/sti_college/" class="social_links"><i class="fa-brands fa-instagram"></i><span> @sti_college</span></a>
            <a href="https://x.com/sticollege?s=20" class="social_links"><i class='fa-brands fa-x-twitter'></i><span> @sticollege</span></a>
        </div>
        <div class="copyright">
            <p class="text">Copyright &copy; <span id="current-year"></span> STI College Alabang. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="js/copyright.js"></script>
</body>

</html>