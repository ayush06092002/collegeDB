<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute a query to check if the teacher exists
    $check_teacher_query = "SELECT teacher_id, teacher_name, username, password FROM teachers WHERE username = ?";
    $check_teacher_stmt = $conn->prepare($check_teacher_query);
    $check_teacher_stmt->bind_param("s", $username);
    $check_teacher_stmt->execute();
    $check_teacher_stmt->store_result();
    if ($check_teacher_stmt->num_rows > 0) {
        // Teacher exists; retrieve stored hashed password
        $check_teacher_stmt->bind_result($teacher_id, $teacher_name, $username, $stored_password);
        $check_teacher_stmt->fetch();

    echo "hsj";
    // Verify the provided password against the stored hashed password
        if (password_verify($password, $stored_password)) {
            // Password is correct; authentication successful

    echo "hsj";
    // Store teacher data in session
            $_SESSION['id'] = $teacher_id;
            $_SESSION['username'] = $username;
            $_SESSION['teacher_name'] = $teacher_name;
            // Redirect to the teacher dashboard or any desired page
            header("location: teacher_panel.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['login_error'] = "Invalid password";
        }
    } else {
        // Teacher does not exist
        $_SESSION['login_error'] = "Invalid username";
    }

    $check_teacher_stmt->close();
    $conn->close();
} else {
    // Redirect to the login page if accessed directly without POST data
    header("location: teacher_login.php");
}
