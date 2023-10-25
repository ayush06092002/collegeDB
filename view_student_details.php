<?php
if (isset($_GET['roll_number'])) {
    require('db.php');
    $roll_number = $_GET['roll_number'];

    // Fetch student details from the database
    $query = "SELECT * FROM students WHERE roll_number = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roll_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_name = $row['student_name'];
        $department = $row['department'];

        // Display student details
        echo "<h2>Student Details</h2>";
        echo "<p>Roll Number: $roll_number</p>";
        echo "<p>Name: $student_name</p>";
        echo "<p>Department: $department</p>";

        // You can add more details here
    } else {
        echo "Student not found.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Roll number not provided.";
}
?>
