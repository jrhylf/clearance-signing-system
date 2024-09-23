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
    <link rel="stylesheet" href="css/php_dashboard.css">
</head>

<body>
    <?php
        $departmentList = mysqli_query($db, "SELECT * FROM tbl_departments");
        if (mysqli_num_rows($departmentList) > 0) {
            while ($row = mysqli_fetch_array($departmentList)) {
    ?>
            <div class="reports_box">
                <div class="box">
                    <h2 class="acad_info"><?php echo $row['department_name']; ?></h2>
                    <label class="sy_sem_maintenance"><?php echo $row['dept_description']; ?></label>
                </div>
            </div>
    <?php }
        } else {
            echo '<label class="sy_sem_maintenance">No current departments available.</label>';
        }
    ?>
</body>

</html>