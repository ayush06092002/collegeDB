<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $roll_number = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute a query to check if the student exists
    $check_student_query = "SELECT roll_number, student_name, department, password FROM students WHERE roll_number = ?";
    $check_student_stmt = $conn->prepare($check_student_query);
    $check_student_stmt->bind_param("s", $roll_number);
    $check_student_stmt->execute();
    $check_student_stmt->store_result();

    if ($check_student_stmt->num_rows > 0) {
        // Student exists; retrieve stored data
        $check_student_stmt->bind_result($roll_number, $student_name, $department, $stored_password);
        $check_student_stmt->fetch();

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $stored_password)) {
            // Password is correct; authentication successful

            // Store student data in session
            $_SESSION['roll_number'] = $roll_number;
            $_SESSION['student_name'] = $student_name;
            $_SESSION['department'] = $department;

            // Redirect to the student dashboard or any desired page
            header("location: student_panel.php");
        } else {
            // Password is incorrect
            $_SESSION['login_error'] = "Invalid password";
            echo "Invalid Password";
            echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "student_login.php";
            }, 3000);
            </script>';
            exit();
        }
    } else {
        // Student does not exist
        $_SESSION['login_error'] = "Invalid roll number";
        echo "Inavlid Username";
            echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "student_login.php";
            }, 3000);
            </script>';
            exit();
    }

    $check_student_stmt->close();
    $conn->close();
} else {
    // Redirect to the login page if accessed directly without POST data
    header("location: student_login.php");
}
?>
