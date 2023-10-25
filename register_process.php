<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // 1 for admin, 0 for regular user

    // Perform validation (e.g., check for duplicate usernames and valid email format)

    // Insert user data into the database
    $sql = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $password, $is_admin);

    if ($stmt->execute()) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
