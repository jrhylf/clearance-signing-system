console.log("Delete Section Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a Section
    $(document).on("click", ".section-delete-btn", function () {
        var sectionId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this Section?",
            function () { // If the user clicks "OK"
                // Send an AJAX request to delete the Section
                $.ajax({
                    url: "php_page_contents/delete_process/delete_section.php",
                    type: "POST",
                    data: { id: sectionId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("Section Deleted");
							console.log("Section Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("Section Deleted Error");
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
