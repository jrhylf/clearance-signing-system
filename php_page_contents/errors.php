<h6 class="errors" id="errorPrompt" style="color: red; font-size: clamp(12px, 5vh, 16px); font-weight: normal; margin-bottom: 0px;">
	<?php
		// Check for errors
		if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
			$errors = $_SESSION['errors'];

			// Display errors as needed
			foreach ($errors as $error) {
				echo $error;
			}

			// Clear the errors from the session
			unset($_SESSION['errors']);
		}
	?>
</h6>
