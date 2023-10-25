<?php
session_start();

// Check if the user is logged in and is an admin
if (isset($_SESSION['id']) && isset($_SESSION['username']) && $_SESSION['is_admin'] == 1) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require('db.php');

        // Process the form data and insert into the database
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role']; // "teacher" or "student"

        // Insert the data into the database based on the selected role
        $sql = "INSERT INTO " . $role . "s (name, email) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            echo "ID created successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect to the login page or display an error message.
    header("location: login.php");
    exit();
}

