<?php
require('db.php');

if (isset($_GET['roll_number']) && isset($_GET['course_name'])) {

    // Collect the student's roll number and course name from the URL
    $roll_number = $_GET['roll_number'];
    $course_name = $_GET['course_name'];

    // Delete the student's specific course from approved courses
    $delete_approved_courses_query = "DELETE FROM approved_courses WHERE student_roll_number = ? AND course_name = ?";
    $delete_approved_courses_stmt = $conn->prepare($delete_approved_courses_query);
    $delete_approved_courses_stmt->bind_param("ss", $roll_number, $course_name);

    // Execute the deletion query
    if ($delete_approved_courses_stmt->execute()) {
        echo "Student's course deleted from approved courses successfully.";
    } else {
        echo "Error deleting student's course from approved courses: " . $conn->error;
    }

    // Close the prepared statement and the database connection
    $delete_approved_courses_stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
