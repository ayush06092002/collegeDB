<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require('db.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user input
    if (empty($username) || empty($password)) {
        // Handle empty fields
        echo "Both username and password are required.";
        exit();
    }

    // Query the database to retrieve user data
    $sql = "SELECT id, username, password, is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $username, $hashed_password, $is_admin);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $is_admin;

            if ($_SESSION['is_admin'] == 1) {
                // Redirect to the admin panel for admin users
                header("location: admin_panel.php");
            } else {
                // Redirect to a non-admin page for regular users
                header("location: non_admin_page.php");
            }
            exit();
        } else {
            echo "Incorrect username or password.";
        }
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
