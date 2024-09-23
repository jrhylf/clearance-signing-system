// // Get activity log from local storage, or initialize an empty array
// let activityLog = JSON.parse(localStorage.getItem('activityLog')) || [];

// // Display activity log in reverse order (latest activity first)
// activityLog.reverse().forEach(activity => {
//     addActivityToLog(activity);
// });

// // Listen for clicks on all buttons on the page
// document.addEventListener('click', e => {
//     const target = e.target;
//     const timestamp = new Date().toLocaleTimeString();

//     // Add activity to log
//     activityLog.unshift({ time: timestamp, action: `Clicked ${target.innerText}` });
//     addActivityToLog(activityLog[0]);

//     // Save activity log to local storage
//     localStorage.setItem('activityLog', JSON.stringify(activityLog));
// });

// // Function to add an activity to the log
// function addActivityToLog(activity) {
//     const activityLogEl = document.getElementById('activity-log');
//     const li = document.createElement('li');
//     const text = document.createTextNode(`${activity.time}: ${activity.action}`);

//     li.appendChild(text);
//     activityLogEl.insertBefore(li, activityLogEl.firstChild);
// }

// Check if the page is being reloaded
// window.onbeforeunload = function() {
//     // Check if user is logged in
//     if (localStorage.getItem('isLoggedIn')) {
//         // Display message
//         console.log('Page is being reloaded.');
//         const timestamp = new Date().toLocaleTimeString();
//         const loginMessage = `${headerTextEl} reloaded the page.`;

//         activityLog.unshift({ time: timestamp, action: loginMessage });
//         addActivityToLog(activityLog[0]);
//         localStorage.setItem("activityLog", JSON.stringify(activityLog));
//     }
// };

// function logLogout() {
// 	const timestamp = new Date().toLocaleTimeString();
// 	const logoutMessage = `${headerTextEl} Logged out.`;

// 	activityLog.unshift({ time: timestamp, action: logoutMessage });
// 	addActivityToLog(activityLog[0]);
// 	localStorage.setItem("activityLog", JSON.stringify(activityLog));
// }

// const logoutButton = document.getElementById("logout-btn");

// logoutButton.addEventListener("click", () => {
// 	// Code to handle the logout process

// 	// Call the logLogout function
// 	logLogout();
// });

// Get activity log from local storage, or initialize an empty array
let activityLog = JSON.parse(localStorage.getItem('activityLog')) || [];

// Display activity log in reverse order (latest activity first)
activityLog.reverse().forEach(activity => {
    addActivityToLog(activity);
});

const headerTextEl = document.getElementById("user-name").textContent;

// Listen for clicks on all buttons on the page
document.addEventListener('click', e => {
    const target = e.target;
    const timestamp = new Date().toLocaleTimeString();

    // Add activity to log
    activityLog.unshift({
			time: timestamp,
			action: `${headerTextEl} Clicked ${target.innerText}.`,
		});
    addActivityToLog(activityLog[0]);

    // Save activity log to local storage
    localStorage.setItem('activityLog', JSON.stringify(activityLog));
});

// Function to add an activity to the log
function addActivityToLog(activity) {
    const activityLogEl = document.getElementById('activity-log');
    const li = document.createElement('li');
    const text = document.createTextNode(`${activity.time}: ${activity.action}`);

    li.appendChild(text);
    activityLogEl.insertBefore(li, activityLogEl.firstChild);
}

// Function to log the login process
// function logLogin() {
//     const timestamp = new Date().toLocaleTimeString();
//     const loginMessage = `${headerTextEl} Logged in.`;

//     activityLog.unshift({ time: timestamp, action: loginMessage });
//     addActivityToLog(activityLog[0]);
//     localStorage.setItem('activityLog', JSON.stringify(activityLog));
// }

// const loginButton = document.getElementById("login-btn");

// logoutButton.addEventListener("click", () => {
// 	// Call the logLogin function when the user logs in
// 	logLogin();
// });


// TODO: FIX LOGIN AND LOGOUT RESPONSE