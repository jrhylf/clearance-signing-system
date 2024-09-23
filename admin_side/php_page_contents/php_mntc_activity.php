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
    <link rel="stylesheet" href="css/php_maintenance_contents.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body onload="activityTable()">

    <script type="text/javascript">
        function activityTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("activityTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/activity_table_contents.php");
            xhttp.send();
        }

        setInterval(function() {
            activityTable();
        }, 1000);
    </script>

    <div class="departments_box">
        <div class="box">
            <h2>Activity</h2>
            <label>In this module, the admin can view the audit trails per department.</label>
            <div class="table_container" id="activityTable">
                
            </div>
        </div>
    </div>
    <!-- <span>Maintenance Activity</span> -->

    <!-- <script src="js/input_restriction.js"></script> -->
</body>

</html>