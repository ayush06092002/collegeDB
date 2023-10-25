<?php
// Include the database connection
require('db.php');

session_start();
$student_roll_number = $_SESSION['roll_number'];

// Query to fetch approved courses for the student
$query = "SELECT * FROM approved_courses WHERE student_roll_number = '$student_roll_number'";
$result = $conn->query($query);

$approved_courses = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $approved_courses[] = $row;
    }
}

// Close the database connection
$conn->close();
?>
