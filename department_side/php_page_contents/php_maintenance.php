<?php
include('conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/php_maintenance.css">
    <link rel="stylesheet" href="css/php_dashboard.css">
</head>

<body>
    <div class="mntc_nav">
        <div class="mntc_nav_menu">
            <h2>Maintenance</h2><br>
            <ul>
                <?php
                // Assume $userRole contains the role of the current user (e.g., "Registrar")
                $userRole = $department; // You need to implement a function to get the user's role

                // Check if the user is the Registrar
                $isRegistrar = ($userRole == 'Registrar');
                ?>
                <li class="list"><a  class="nav_option" href="mainPage.php?page=php_mntc_students"><span>Students</span></a></li>
                <!-- Limited to Registrar Only -->
                <?php if ($isRegistrar): ?>
                    <li class="list"><a  class="nav_option" href="mainPage.php?page=php_mntc_academic"><span>Academic</span></a></li>
                    <li class="list"><a  class="nav_option" href="mainPage.php?page=php_archived"><span>Archived Students</span></a></li>
                <?php endif; ?>

                <!-- All Departments -->
                <li class="list"><a  class="nav_option" href="mainPage.php?page=php_mntc_activity"><span>Activity</span></a></li>
                <li class="list"><a  class="nav_option" href="mainPage.php?page=php_mntc_announcement"><span>Announcement</span></a></li>
            </ul>
        </div>
    </div>
</body>

</html>