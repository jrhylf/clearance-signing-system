console.log("Delete user Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a user
    $(document).on("click", ".user-delete-btn", function () {
        var userId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this user?",
            function () { // If the user clicks "OK"
                // Send an AJAX request to delete the user
                $.ajax({
                    url: "php_page_contents/delete_process/delete_user.php",
                    type: "POST",
                    data: { id: userId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("User Deleted");
							console.log("User Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("User Deleted Error");
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
