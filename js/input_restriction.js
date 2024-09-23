// Get the current year
const currentYear = new Date().getFullYear();

// Get the select element
const select1 = document.getElementById("year-select1");

// Loop through years from current year down to 1980 and create an option for each year
for (let year = currentYear; year >= currentYear-10; year--) {
	const option = document.createElement("option");
	option.value = year;
	option.text = year.toString();
	select1.add(option);
}

// Input text only
const courseInput = document.getElementById("course-enter");
courseInput.addEventListener("keydown", function (event) {
	// Allow white spaces and alphabetical characters
	if (!/[a-zA-Z\s]/.test(event.key)) {
		event.preventDefault();
	}
});

const courseCodeInput = document.getElementById("course-code-enter");
courseCodeInput.addEventListener("keydown", function (event) {
	// Allow white spaces and alphabetical characters
	if (!/[a-zA-Z\s]/.test(event.key)) {
		event.preventDefault();
	}
});

// Input num only
const sectionNumberInput = document.getElementById("section-enter");
sectionNumberInput.addEventListener("input", (event) => {
	const input = event.target;
	input.value = input.value.replace(/[^0-9]/g, "");
});

const StudIdNumberInput = document.getElementById("stud-id-enter");
StudIdNumberInput.addEventListener("input", (event) => {
	const input = event.target;
	input.value = input.value.replace(/[^0-9]/g, "");
});

const semester = document.getElementById("sem-enter");
semester.addEventListener("input", (event) => {
	const input = event.target;
	input.value = input.value.replace(/[^0-9]/g, "");
});

// Input num, text, and white space only
// const semInput = document.getElementById("sem-enter");
// semInput.addEventListener("input", function () {
// 	this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, "");
// });



// TODO: Back to top
// const backToTopBtn = document.querySelector('#back-to-top-btn');

// // Add a scroll event listener to the window
// window.addEventListener('scroll', () => {
//   	// If the user has scrolled 200 pixels or more
// 	if (window.scrollY >= 200) {
// 		// Show the back-to-top button
// 		backToTopBtn.style.display = "block";
// 	} else {
// 		// Hide the back-to-top button
// 		backToTopBtn.style.display = "none";
// 	}
// });

// // Add a click event listener to the button
// backToTopBtn.addEventListener('click', () => {
//   	// Scroll back to the top of the page with a smooth animation
// 	window.scrollTo({
// 		top: 0,
// 		behavior: 'smooth'
// 	});
// });

// TODO: POPUP FORM FOR ANNOUNCEMENT VIEWING
// POPUP FORM for DEPARTMENT
// var dept_modal = document.getElementById("dept-modal"); // Get the modal

// // Get the button that opens the modal
// var btn_add_dept = document.getElementById("add_dept_modal_form");

// // Get the <span> element that closes the modal
// var span_close_dept = document.getElementsByClassName("close_dept_modal")[0];

// // When the user clicks the button, open the modal
// btn_add_dept.onclick = function() {
// 	dept_modal.style.display = "block";
// }

// // When the user clicks on <span> (x), close the modal
// span_close_dept.onclick = function() {
// 	dept_modal.style.display = "none";
// }

// // POPUP FORM for USERS
// var users_modal = document.getElementById("users-modal"); // Get the modal

// // Get the button that opens the modal
// var btn_add_user = document.getElementById("add_users_modal_form");

// // Get the <span> element that closes the modal
// var span_close_user = document.getElementsByClassName("close_users_modal")[0];

// // When the user clicks the button, open the modal
// btn_add_user.onclick = function () {
// 	users_modal.style.display = "block";
// };

// // When the user clicks on <span> (x), close the modal
// span_close_user.onclick = function () {
// 	users_modal.style.display = "none";
// };

// // POPUP FORM for STUDENTS
// var student_modal = document.getElementById("student-modal"); // Get the modal

// // Get the button that opens the modal
// var btn_add_student = document.getElementById("add_students_modal_form");

// // Get the <span> element that closes the modal
// var span_close_student = document.getElementsByClassName("close_students_modal")[0];

// // When the user clicks the button, open the modal
// btn_add_student.onclick = function () {
// 	student_modal.style.display = "block";
// };

// // When the user clicks on <span> (x), close the modal
// span_close_student.onclick = function () {
// 	student_modal.style.display = "none";
// };

// POPUP FORM
