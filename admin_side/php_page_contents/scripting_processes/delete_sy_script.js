console.log("Delete School Year Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a school year
    $(document).on("click", ".sy-delete-btn", function () {
        var schoolYearId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this school year?",
            function () { // If the school year clicks "OK"
                // Send an AJAX request to delete the school year
                $.ajax({
                    url: "php_page_contents/delete_process/delete_school_year.php",
                    type: "POST",
                    data: { id: schoolYearId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("School Year Deleted");
							console.log("School Year Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("School Year Deleted Error");
                        }
                    },
                    error: function () {
                        alertify.error("An error occurred.");
                    },
                });
            },
            function () { // If the school year clicks "Cancel"
                // Do nothing or provide feedback to the school year
                alertify.message("Deletion canceled.");
            }
        );
    });
});
