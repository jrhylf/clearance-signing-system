console.log("Delete department Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a department
    $(document).on("click", ".dept-delete-btn", function () {
        var departmentId = $(this).data("id");
        var departmentName = $(this).data("department_name");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete " + departmentName + " department?",
            function () { // If the user clicks "OK"
                // Send an AJAX request to delete the department
                $.ajax({
                    url: "php_page_contents/delete_process/delete_department.php",
                    type: "POST",
                    data: { id: departmentId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("Department Deleted");
							console.log("Department Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("Department Deleted Error");
                        }
                    },
                    error: function () {
                        alertify.error("An error occurred.");
                    },
                });
            },
            function () { // If the user clicks "Cancel"
                // Do nothing or provide feedback to the user
                alertify.message("Deletion canceled.");
            }
        );
    });
});
