<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    // Collect data from the form
    $teacher_name = $_POST['teacher_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validate the data (add more validation as needed)
    if (empty($teacher_name) || empty($username) || empty($password)) {
        echo "Teacher name, username, and password are required fields.";
        exit();
    }

    // Insert the new teacher and teacher ID into the teachers table
    $sql = "INSERT INTO teachers (teacher_name, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $teacher_name, $username, $password);

    if ($stmt->execute()) {
        echo "Teacher ID created successfully!";
        echo '<script type="text/javascript">
            setTimeout(function(){
                window.location = "create_teacher_id.php";
            }, 3000);
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
