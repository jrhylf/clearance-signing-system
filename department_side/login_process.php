<?php
// Start Session
session_start();

// Database connection
include('conn.php');

// Variables
$username = "";
$password = "";
$errors = array();

// Users Login
if (isset($_POST['login'])) {
    // Get admin input and modify input
    $username = trim($_POST['user']);
    $password = trim($_POST['pass']);

    // Create a prepared statement
    $stmt = mysqli_prepare($db, "SELECT * FROM tbl_users WHERE user_username = ?");

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);

    // Get the result of the executed statement
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the row from the result
    $row = mysqli_fetch_assoc($result);

    // If the input is a correct combination
    if ($row && password_verify($password, $row['user_password'])) {
        $_SESSION['user_username'] = $row['user_username']; // Kailangan to para ma-verify yung username
        $_SESSION['department_assigned'] = $row['department_assigned'] . ' | ' . $row['first_name'] . ' ' . $row['last_name']; // Ito yung mag didisplay sa Dashboard (ex. Welcome Administrator)
        $_SESSION['department'] = $row['department_assigned'];
        $_SESSION['user'] = $row['first_name'] . ' ' . $row['last_name'];

        // Initialize success array if not defined
        if (!isset($_SESSION['success'])) {
            $_SESSION['success'] = array();
        }

        array_push($_SESSION['success'], "Logged in successfully.");

        // Insert Audit Trail
        $current_date = date("Y-m-d");
        $current_time = date("H:i:s");
        $user = $_SESSION['user'];
        $department_name = $_SESSION['department'];
        $activity = "Logged in.";

        $activityInsert = "INSERT INTO tbl_activity (date, time, user, department_name, activity) VALUES (?, ?, ?, ?, ?)";
        $stmtAddToActivity = mysqli_prepare($db, $activityInsert);
        mysqli_stmt_bind_param($stmtAddToActivity, "sssss", $current_date, $current_time, $user, $department_name, $activity);
        $addToActivityResult = mysqli_stmt_execute($stmtAddToActivity);

        // Execute the statement and check for errors
        if ($addToActivityResult) {
            echo "Audit trail inserted successfully.";
        } else {
            echo "Error: " . mysqli_error($db);
        }

        // Close the statement
        mysqli_stmt_close($stmtAddToActivity);
        // Insert Audit Trail End

        // Redirect to dashboard page
        header("location: mainPage.php?page=dashboard");
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
