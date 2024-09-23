console.log("Delete announcement Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a announcement
    $(document).on("click", ".announcement-delete-btn", function () {
        var announcementId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this announcement?",
            function () { // If the announcement clicks "OK"
                // Send an AJAX request to delete the announcement
                $.ajax({
                    url: "php_page_contents/delete_process/delete_announcement.php",
                    type: "POST",
                    data: { id: announcementId },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            // Display success message
                            alertify.success(response.message);
							console.log(response.message);

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.status === 'error') {
                            alertify.error(response.message);
                            console.log(response.message);
                        }
                    },
                    error: function () {
                        alertify.error("An error occurred.");
                    },
                });
            },
            function () { // If the announcement clicks "Cancel"
                // Do nothing or provide feedback to the announcement
                alertify.message("Deletion canceled.");
            }
        );
    });
});
