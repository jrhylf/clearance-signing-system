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
    <link rel="stylesheet" href="css/php_maintenance_contents.css">
</head>

<body>
    <!-- <div class="summary_content">
        <div class="box_summary">
            <h4 class="total">School Year and Term: 
            <?php
            // Query to select the active school year and semester
            $query = "SELECT CONCAT(sy_start, ' - ', sy_end) AS school_year FROM tbl_sy_sem ";
            $result = mysqli_query($db, $query);

            if ($result) {
                // Check if any rows were returned
                if (mysqli_num_rows($result) > 0) {
                    // Fetch the result
                    $row = mysqli_fetch_assoc($result);
                    $schoolYear = $row['school_year'];
                } else {
                    $schoolYear = "No active school year found.";
                }

                // Free the result set
                mysqli_free_result($result);
            } else {
                // Handle query error
                echo "Error executing query: " . mysqli_error($db);
            }
            ?>

            HTML part with the select dropdown
            <select class="dp_dropdown" id="sy_sem" name="sy_sem" autocomplete="off" required>
                <option value="<?php echo htmlspecialchars($schoolYear); ?>"><?php echo htmlspecialchars($schoolYear); ?></option>
            </select>

            </h4>
        </div>
    </div> -->

    <?php
        // TODO: DAPAT KITA KUNG ANONG REQUIREMENT(S) ANG KELANGAN IPASA NG STUDENT GALING DATABASE
        $studentID = $_SESSION['student_id'];
        $departmentList = mysqli_query($db, "SELECT * FROM tbl_cleared WHERE student_id = $studentID");
        if (mysqli_num_rows($departmentList) > 0) {
            while ($row = mysqli_fetch_array($departmentList)) {
    ?>
            <div class="reports_box">
                <div class="box">
                    <h2 class="acad_info"><?php echo $row['department']; ?></h2>
                    <label class="sy_sem_maintenance"><?php echo $row['remarks']; ?></label>
                </div>
            </div>
    <?php }
        } else {
            echo '<label class="sy_sem_maintenance">No current departments available.</label>';
        }
    ?>
</body>

</html>