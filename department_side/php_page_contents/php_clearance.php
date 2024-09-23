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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/php_maintenance_contents.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Data table -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <!-- QR Code Scanner -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link rel="stylesheet" href="css/qrscanner.css">

    <!-- Include Select2 CSS -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> -->
    <link rel="stylesheet" href="css/select2.min.css">

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include Alertify CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <!-- Include Alertify JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <!-- Scripts for Department -->
    <script src="php_page_contents/scripting_processes/delete_requirement_script.js"></script>
</head>

<body onload="clearedTable(), holdTable()">
    <script type="text/javascript">
        function clearedTable() {
            let table = new DataTable('#tableCleared');
        }

        function holdTable() {
            let table = new DataTable('#tableHold');
        }
    </script>

    <div class="departments_box">
        <div class="box">
            <h2 class="acad_info">Clearance</h2>
            <label class="sy_sem_maintenance">In this module, the department can clear students, manage clearance
                history, and scan QR Code to clear students.</label>
        </div>
    </div>

    <div class="departments_box">
        <div class="box">
            <h2 class="acad_info">Cleared</h2>
            <label class="sy_sem_maintenance">In this table, the department can see cleared students.</label>
            <!-- For the Cleared table -->
            <form action="php_page_contents/transfer_records.php" method="post" id="transferClearedForm">
                <input type="hidden" name="source_table" value="tbl_cleared">
                <input type="hidden" name="transfer_action" value="hold_student">
                <input type="hidden" name="selected_rows" id="selectedRowsClearedInput" value="">
                <!-- <button type="button" class="btn" onclick="reloadClearedTable()">Hold Student</button> -->
                <!-- // TODO: onclick, a modal form must open to input reason for holding. -->

                <!-- Add a modal HTML structure -->
                <!-- // TODO: Fetch the data in the table tbl_cleared (student_id, last_name, first_name, course_code, section) and display it in the modal form using labels or p tags. The only editable field is the reason -->
                <!-- // TODO: Based on the `id` from the hold_validate(), fetch the data that matched the id. -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <!-- Add hidden input fields for other data -->
                        <label for="student_id">Student ID:</label>
                        <span id="student_id" name="student_id"></span><br>

                        <label for=" last_name">Lastname:</label>
                        <span id="last_name" name="last_name"></span><br>

                        <label for="first_name">Firstname:</label>
                        <span id="first_name" name="first_name"></span><br>

                        <label for="course_code">Course:</label>
                        <span id="course_code" name="course_code"></span><br>

                        <label for="section">Section:</label>
                        <span id="section" name="section"></span><br><br>

                        <!-- Add your form field for inputting the reason for holding -->
                        <label for="reason">Deficiencies:</label>
                        <input type="text" id="reason" class="dp_name" name="reason" autofocus required> <!-- autofocus not working -->

                        <!-- Add hidden input fields for other data -->
                        <input type="hidden" id="student_id_input" name="student_id">
                        <input type="hidden" id="last_name_input" name="last_name">
                        <input type="hidden" id="first_name_input" name="first_name">
                        <input type="hidden" id="course_code_input" name="course_code">
                        <input type="hidden" id="section_input" name="section">
                        <input type="hidden" id="department_input" name="department">

                        <!-- Add a submit button or any other buttons you may need -->
                        <button type="submit">Submit</button>
                    </div>
                </div>

                <!-- Your existing button -->
                <button type="button" class="btn" onclick="hold_validate()">Hold Student</button>

                <!-- JavaScript to handle modal functionality -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const checkboxes = document.querySelectorAll('.select-checkbox');

                        checkboxes.forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                updateSelectedRows();
                            });
                            console.log("Checkbox clicked!");
                        });

                        function updateSelectedRows() {
                            const selectedClearedRows = [];
                            const selectedHoldRows = [];

                            checkboxes.forEach(checkbox => {
                                if (checkbox.checked) {
                                    const dataId = checkbox.getAttribute(
                                        'data-id'
                                    ); // TODO: Based on this id, the modal should fetch the data from tbl_cleared and populate the form
                                    selectedClearedRows.push(dataId);
                                    selectedHoldRows.push(dataId);
                                    console.log(dataId);
                                }
                            });
                            document.getElementById('selectedRowsClearedInput').value = selectedClearedRows.join(
                                ',');
                            document.getElementById('selectedRowsHoldInput').value = selectedHoldRows.join(',');
                        }
                    });

                    function hold_validate() {
                        var table_cleared = document.getElementById("tableCleared");
                        var rows = table_cleared.getElementsByTagName("tr");

                        var checkedRowsFound = false; // Flag to check if any row is checked

                        for (var i = 1; i < rows.length; i++) {
                            var checkbox = rows[i].getElementsByClassName("select-checkbox")[0];

                            if (checkbox.checked) {
                                checkedRowsFound = true;

                                var id = checkbox.getAttribute("data-id");

                                // Send an AJAX request to fetch data
                                $.ajax({
                                    url: "/department_side/php_page_contents/check_process.php",
                                    type: "POST",
                                    data: { id: id },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.success) {
                                            var record = response.data;
                                            if (record) {
                                                // Map the response to the modal
                                                $('#student_id').text(record.student_id);
                                                $('#last_name').text(record.last_name);
                                                $('#first_name').text(record.first_name);
                                                $('#course_code').text(record.course_code);
                                                $('#section').text(record.section);

                                                $('#student_id_input').val(record.student_id);
                                                $('#last_name_input').val(record.last_name);
                                                $('#first_name_input').val(record.first_name);
                                                $('#course_code_input').val(record.course_code);
                                                $('#section_input').val(record.section);
                                            }
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });

                                // Pass the ID to the modal
                                openModal(id);
                                // No need to return here, let the loop continue checking other rows
                            }
                        }

                        if (!checkedRowsFound) {
                            alertify.error("No checked rows found.");
                            console.log("No checked rows found.");
                        }
                    }

                    // Function to open the modal with the given ID
                    function openModal(id) {
                        var modal = document.getElementById('modal');
                        // TODO: Use the ID in your modal logic
                        console.log("Modal opened with ID: " + id);
                        alertify.success("Modal opened with ID: " + id);
                        modal.style.display = 'block';
                    }

                    // Function to close the modal
                    function closeModal() {
                        var modal = document.getElementById('modal');
                        modal.style.display = 'none';
                    }

                    function clear_validate() {
                        var table_hold = document.getElementById("tableHold");
                        var rows = table_hold.getElementsByTagName("tr");

                        var checkedRowsFound = false; // Flag to check if any row is checked

                        for (var i = 1; i < rows.length; i++) {
                            var checkbox = rows[i].getElementsByClassName("select-checkbox")[0];

                            if (checkbox.checked) {
                                checkedRowsFound = true;

                                var id = checkbox.getAttribute("data-id");

                                // Send an AJAX request to update tbl_cleared
                                $.ajax({
                                    url: "/department_side/php_page_contents/clear_process.php",
                                    type: "POST",
                                    data: { id: id },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.success) {
                                            alertify.success(response.message);
                                            // Optionally, you can reload the tbl_hold table or perform other actions
                                            location.reload();
                                        } else {
                                            alertify.error(response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                        alertify.error("Error updating tbl_cleared.");
                                    }
                                });

                                // No need to return here, let the loop continue checking other rows
                            }
                        }

                        if (!checkedRowsFound) {
                            alertify.error("No checked rows found.");
                            console.log("No checked rows found.");
                        }
                    }
                </script>

            </form>

            <div class="table_container" id="clearedTable">
                <!-- Table Records -->
                <?php
                $department = $_SESSION['department'];
                ?>
                <table id="tableCleared" class="flat-table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Student ID</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $clearedTable = mysqli_query($db, "SELECT * FROM tbl_cleared WHERE remarks = 'Cleared' AND department = '$department' ");
                        if (mysqli_num_rows($clearedTable) > 0) {
                            while ($row = mysqli_fetch_array($clearedTable)) {
                                ?>
                        <tr>
                            <td><input type="checkbox" class="select-checkbox"
                                    data-id="<?php echo $row['student_id']; ?>"></td>
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
                            <!-- <td><?php // echo $row['department'] ?></td> -->
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7">No students are currently cleared.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="departments_box">
        <div class="box">
            <h2 class="acad_info">On-hold</h2>
            <label class="sy_sem_maintenance">In this table, the department can see on-hold students.</label>
            <!-- For the On-hold table -->
            <form action="php_page_contents/transfer_records.php" method="post" id="transferHoldForm">
                <input type="hidden" name="source_table" value="tbl_hold">
                <input type="hidden" name="transfer_action" value="clear_student">
                <input type="hidden" name="selected_rows" id="selectedRowsHoldInput" value="">
                <button type="button" class="btn" onclick="clear_validate()">Clear Student</button>
            </form>

            <div class="table_container" id="holdTable">
                <!-- Table Records -->
                <table id="tableHold" class="flat-table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Student ID</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Deficiencies</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $holdTable = mysqli_query($db, "SELECT * FROM tbl_cleared WHERE remarks != 'Cleared' AND department = '$department' ");
                        if (mysqli_num_rows($holdTable) > 0) {
                            while ($row = mysqli_fetch_array($holdTable)) {
                                ?>
                        <tr>
                        <td><input type="checkbox" class="select-checkbox"
                                    data-id="<?php echo $row['student_id']; ?>"></td>
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
                            <td style="color: red;">
                                <?php echo $row['remarks'] ?>
                            </td>
                            <td>
                                <button type="button" class="student-edit-btn edit-btn" data-id="<?php echo $row['student_id']; ?>" onclick="editRecord(<?php echo $row['student_id']; ?>)">Edit</button>
                            </td>
                            <script>
                                function editRecord(id) {
                                    $.ajax({
                                        url: "/department_side/php_page_contents/fetch_hold.php",
                                        type: "POST",
                                        data: {
                                            id: id
                                        },
                                        dataType: "json", // Specify the data type as JSON

                                        success: function (response) {
                                            if (response.success) {
                                                var record = response.data;
                                                if (record) {
                                                    // Map the response to the modal or perform any other actions
                                                    $('#student_id').text(record.student_id);
                                                    $('#last_name').text(record.last_name);
                                                    $('#first_name').text(record.first_name);
                                                    $('#course_code').text(record.course_code);
                                                    $('#section').text(record.section);
                                                    $('#reason').val(record.remarks);

                                                    $('#student_id_input').val(record.student_id);
                                                    $('#last_name_input').val(record.last_name);
                                                    $('#first_name_input').val(record.first_name);
                                                    $('#course_code_input').val(record.course_code);
                                                    $('#section_input').val(record.section);
                                                    $('#reason_input').val(record.remarks);

                                                    // Open the modal if not already open
                                                    openModal(id);
                                                }
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            console.error(error);
                                        }
                                    });
                                }
                            </script>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7">No students are currently on-hold.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="departments_box">
        <div class="box">
            <h2 class="acad_info">QR Scanner</h2>
            <label class="sy_sem_maintenance">In this module, the department can scan QR codes from students to clear
                records.</label>
            <div class="container">
                <h1>Scan QR Codes</h1>
                <div class="section">
                    <div id="my-qr-reader">
                    </div>
                </div>
            </div>
            <script>
                function domReady(fn) {
                    if (
                        document.readyState === "complete" ||
                        document.readyState === "interactive"
                    ) {
                        setTimeout(fn, 1000);
                    } else {
                        document.addEventListener("DOMContentLoaded", fn);
                    }
                }

                domReady(function() {
                    // If found you qr code
                    function onScanSuccess(decodeText, decodeResult) {
                        alertify.success("You Qr is : " + decodeText, decodeResult);
                        console.log("You Qr is : " + decodeText, decodeResult);
                        updateRemarksOnServer(decodeText);
                    }

                    // TODO: Make this scan only once.
                    // Create the QR code scanner
                    let htmlscanner = new Html5QrcodeScanner(
                        "my-qr-reader", {
                            fps: 10,
                            qrbos: 250
                        }
                    );
                    // Optional: Add a callback when scanning is done
                    htmlscanner.render(onScanSuccess);
                });

                function updateRemarksOnServer(studentId) {
                    // Use AJAX to send a request to a PHP script
                    console.log(studentId);
                    $.ajax({
                        url: "php_page_contents/update_remarks.php",
                        type: "POST",
                        data: {
                            student_id: studentId
                        },
                        dataType: "json", // Change to "html" if your server responds with HTML
                        success: function(data) {
                            // Handle the server's response if needed
                            console.log(data);
                            alertify.success(
                                "Remarks updated successfully.");
                            location.reload();
                        },
                        error: function() {
                            // Handle error response
                            console.error("Error updating remarks.");
                            alertify.error("Error updating remarks.");
                        }
                    });
                }
            </script>
        </div>
    </div>
</body>

</html>