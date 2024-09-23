document.addEventListener('DOMContentLoaded', function () {
	var usernameInput = document.getElementById('username');
	var passwordInput = document.getElementById('password-input');

	// Restrict numbers and special characters for username
	usernameInput.addEventListener('input', function () {
		this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
	});

	// Restrict numbers and special characters for password
	passwordInput.addEventListener('input', function () {
		this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
	});
});

