const dropdown = document.querySelector(".dropdown");
const dropdownMenu = document.querySelector(".dropdown_menu");

dropdown.addEventListener("click", () => {
	dropdownMenu.classList.toggle("show");
});
