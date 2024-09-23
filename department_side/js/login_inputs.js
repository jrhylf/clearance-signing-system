document
	.getElementById("show-inputs-btn")
	.addEventListener("click", function () {
		var inputContainer = document.querySelector(".input-container");
		var fadeInputs = document.querySelectorAll(".fade-input");

		if (!inputContainer.classList.contains("show")) {
			inputContainer.classList.add("show");
			inputContainer.style.animation = "slideDown 1s ease";

			fadeInputs.forEach(function (input) {
				input.style.animation = "fadeIn 0.3s ease";
			});
		} else {
			inputContainer.classList.remove("show");
			inputContainer.style.animation = "slideUp 1s ease";

			fadeInputs.forEach(function (input) {
				input.style.animation = "fadeOut 0.3s ease";
			});
		}
	});

