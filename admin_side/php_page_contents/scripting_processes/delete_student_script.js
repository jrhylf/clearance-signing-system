console.log("Delete student Script is running.");
$(document).ready(function () {
    // Function to handle AJAX request for deleting a student
    $(document).on("click", ".student-delete-btn", function () {
        var studentId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the deletion
        alertify.confirm("Confirm Deletion", "Are you sure you want to delete this student?",
            function () { // If the student clicks "OK"
                // Send an AJAX request to delete the student
                $.ajax({
                    url: "php_page_contents/delete_process/delete_student.php",
                    type: "POST",
                    data: { id: studentId },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Display success message
                            alertify.success("Student Deleted");
							console.log("Student Deleted");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.error) {
                            alertify.error("Student Deleted Error");
                        }
                    },
                    error: function () {
                        alertify.error("An error occurred.");
                    },
                });
            },
            function () { // If the student clicks "Cancel"
                // Do nothing or provide feedback to the student
                alertify.message("Deletion canceled.");
            }
        );
    });
});
