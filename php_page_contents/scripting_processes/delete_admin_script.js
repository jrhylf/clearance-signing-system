console.log("Delete admin Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a admin
    $(document).on("click", ".admin-delete-btn", function () {
        var adminId = $(this).data("id");
        var adminName = $(this).data("admin_username");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete " + adminName + " admin?",
            function () { // If the user clicks "OK"
                // Send an AJAX request to delete the admin
                $.ajax({
                    url: "php_page_contents/delete_process/delete_admin.php",
                    type: "POST",
                    data: { id: adminId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("Admin Deleted");
							console.log("Admin Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("Admin Deleted Error");
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
