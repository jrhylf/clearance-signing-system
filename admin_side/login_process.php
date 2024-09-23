<?php
// Start Session
session_start();

// Database connection
include('conn.php');

// Variables
$username = "";
$password = "";
$errors = array();

// Administrator Login
if (isset($_POST['login'])) {
    // Get admin input and modify input
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);

    // Create a prepared statement
    $stmt = mysqli_prepare($db, "SELECT * FROM tbl_administrator WHERE admin_username = ?");

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result of the executed statement
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row from the result
    $row = mysqli_fetch_assoc($result);

    // If the input is a correct combination
    if ($row && password_verify($password, $row['admin_pass'])) {
        $_SESSION['admin_username'] = $row['admin_username']; // Kailangan to para ma-verify yung username
        $_SESSION['position'] = strtoupper($row['position']) . ' ' . strtoupper($row['admin_lastname']); // Ito yung mag didisplay sa Dashboard (ex. Welcome Administrator)

        // Initialize success array if not defined
        if (!isset($_SESSION['success'])) {
            $_SESSION['success'] = array();
        }

        array_push($_SESSION['success'], "Logged in successfully.");

        // Redirect to dashboard page
        header("location: mainPage.php");
        exit();
    } else {
        array_push($errors, "Incorrect Username and Password combination.");
        $_SESSION['errors'] = $errors;
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// echo  "<br>";
// echo "Last Name: " . $user->data->getSurname() . "<br>";
// echo "First Name: " . $user->data->getGivenName() . "<br>";
// echo "<br>";
// echo "Full Name: " . $user->data->getDisplayName() . "<br>";
// echo "Email: " . $user->data->getUserPrincipalName() . "<br>";

// To check the credentials needed
// echo "<br>";
// var_dump($user->data);
?>
