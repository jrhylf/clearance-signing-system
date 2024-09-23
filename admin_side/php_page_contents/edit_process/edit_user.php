<?php
// Assuming you have a database connection
include('conn.php');

$id = $_POST['id'];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
$middlename = $_POST['middlename'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$username = $_POST['username'];
$password = $_POST['password'];
$department_dd = $_POST['department_assigned'];
$position = $_POST['position'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

if (empty($middlename) || empty($contact)) {
    $middlename = "N/A";
    $contact = 0;
}

// Use prepared statement to prevent SQL injection
$query = "UPDATE tbl_users SET last_name = ?, first_name = ?, middle_name = ?, gender = ?, department_assigned = ?, position = ?, user_username = ?, user_password = ? , email = ? , contact = ? WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "ssssssssssi", $lastname, $firstname, $middlename, $gender, $department_dd, $position, $username, $hashed_password, $email, $contact, $id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    // Fetch user from tbl_users
    $fetchUser = "SELECT CONCAT(last_name, ', ', first_name) AS user FROM tbl_users WHERE user_username = ?";
    $stmtFetchUser = mysqli_prepare($db, $fetchUser);
    mysqli_stmt_bind_param($stmtFetchUser, "s", $username);
    mysqli_stmt_execute($stmtFetchUser);
    $userResult = mysqli_stmt_get_result($stmtFetchUser);

    if ($row = mysqli_fetch_assoc($userResult)) {
        $user = $row['user'];

        // Update department_assigned in tbl_departments
        $updateDepartment = "UPDATE tbl_departments SET user = ? WHERE department_name = ?";
        $stmtUpdateDepartment = mysqli_prepare($db, $updateDepartment);
        mysqli_stmt_bind_param($stmtUpdateDepartment, "ss", $user, $department_dd);
        $updateToUsersResult = mysqli_stmt_execute($stmtUpdateDepartment);

        if ($updateToUsersResult) {
            echo json_encode(array('success' => true));
            // Additional log can be added to the response data
            // echo json_encode(array('success' => true, 'log' => 'Updated Department User'));
        } else {
            echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
        }
    } else {
        echo json_encode(array('success' => false, 'error' => 'User not found in tbl_users'));
    }
} else {
    echo json_encode(array('success' => false, 'error' => mysqli_error($db)));
}

mysqli_stmt_close($stmt);
mysqli_close($db);
?>
