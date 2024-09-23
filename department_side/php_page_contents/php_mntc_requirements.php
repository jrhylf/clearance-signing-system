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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
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

<body onload="requirementsTable()">

    <script type="text/javascript">
        function requirementsTable() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById("requirementsTable").innerHTML = this.responseText;
            }
            xhttp.open("GET", "php_page_contents/table_contents/requirements_table_contents.php");
            xhttp.send();
        }
    </script>
    
    <div class="departments_box">
        <div class="box">
            <h2>Requirements</h2>
            <label>In this module, the department can add, edit, delete requirements.</label>
            <br><br>
            <form action="">
                <label for="input_requirement">Add Requirement:</label><br>
                <div class="req_box">
                    <input type="text" class="dp_name" id="input_requirement" placeholder="e.g. 2x2 picture" required>
                    <button type="submit" class="btn" id="add_requirement">ADD</button>
                </div>
            </form>
            <br>
            <div class="table_container" id="requirementsTable">
                <!-- Table Records -->
                
                <script>
                    // Function to reload the records inside the table
                    function reloadRequirementsTable() {
                        // Send an AJAX request to get the updated records
                        $.ajax({
                            url: "php_page_contents/table_contents/requirements_table_contents.php", // Adjust the relative path
                            type: "POST",
                            dataType: "html",
                            success: function (data) {
                                // Update the content of the requirementsTable div with the updated records
                                $("#requirementsTable").html(data);
                                // alertify.success("Requirements table reloaded.");
                            },
                            error: function () {
                                alertify.error("Error reloading Requirements table.");
                            },
                        });
                    }
                </script>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Function to handle form submission
                $("#add_requirement").click(function(e) {
                    e.preventDefault();

                    // Get input value
                    var requirement = $("#input_requirement").val();

                    // AJAX request
                    $.ajax({
                        type: "POST",
                        url: "php_page_contents/add_process/add_requirement.php", // Replace with the actual PHP file name
                        data: { requirement: requirement },
                        dataType: "json",
                        success: function(response) {
                            // Handle success response
                            if (response.success.length > 0) {
                                $('#input_requirement').val('');

                                alertify.success(response.success[0]);
                                console.log(response.success[0]);
                                // You can also update the table dynamically here
                                // Call a function to update the requirements table
                                reloadRequirementsTable();
                            }

                            // Handle error response
                            if (response.error.length > 0) {
                                alertify.error(response.error[0]);
                                console.log(response.error[0]);
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle AJAX errors
                            alertify.error("An error occurred while processing your request.");
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    </div>
</body>

</html>