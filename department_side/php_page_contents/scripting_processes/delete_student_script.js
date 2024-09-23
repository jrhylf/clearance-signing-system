console.log("Delete student Script is running.");

$(document).ready(function () {
    // Function to handle AJAX request for deleting a student
    $(document).on("click", ".student-delete-btn", function () {
        var studentId = $(this).data("id");
        var row = $(this).closest("tr"); // Get the table row associated with the record

        // Use Alertify to confirm the Deletion/Archiving
        alertify.confirm("Confirm Archiving", "Are you sure you want to archive this student?",
            function () { // If the student clicks "OK"
                // Send an AJAX request to delete the student
                $.ajax({
                    url: "php_page_contents/delete_process/delete_student.php",
                    type: "POST",
                    data: { id: studentId },
                    dataType: "json", // Expect JSON response
                    success: function (response) {
                        if (response.status === 'success') {
                            // Display success message
                            alertify.success("Student Archived");
                            console.log("Student Archived");

                            // Optionally, you can remove the deleted row from the table
                            row.remove();
                        } else if (response.status === 'error') {
                            alertify.error("Student Archiving Error: " + response.message);
                            console.log("Student Archiving Error: " + response.message);
                        }
                    },
                    error: function () {
                        alertify.error("An error occurred.");
                        console.log("An error occurred. LOL");
                    },
                });
            },
            function () { // If the student clicks "Cancel"
                alertify.message("Archiving canceled.");
                console.log("Archiving canceled.");
            }
        );
    });
});
