console.log("Delete Course Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a Course
    $(document).on("click", ".course-delete-btn", function () {
        var courseId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this Course?",
            function () { // If the user clicks "OK"
                // Send an AJAX request to delete the Course
                $.ajax({
                    url: "php_page_contents/delete_process/delete_course.php",
                    type: "POST",
                    data: { id: courseId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("Course Deleted");
							console.log("Course Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("Course Deleted Error");
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
