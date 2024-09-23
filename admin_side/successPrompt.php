<h6 class="success" id="successPrompt" style="color: green; font-size: clamp(12px, 5vh, 16px); font-weight: normal; margin-bottom: 0px;">
	<?php
		// Check for success
		if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
			$success = $_SESSION['success'];

			// Display success as needed
			foreach ($success as $success) {
				echo $success;
			}

			// Clear the success from the session
			unset($_SESSION['success']);
		}
	?>
</h6>
