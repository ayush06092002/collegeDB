<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['roll_number'])) {
    require('db.php');

    $student_roll_number = $_SESSION['roll_number'];
    $requested_courses = $_POST['courses'];

    if (!empty($requested_courses)) {
        // Initialize an array to store unique course IDs
        $unique_course_ids = [];

        // Prepare a query to fetch existing requests for the student
        $existing_requests_query = "SELECT course_id FROM requestcourses WHERE student_roll_number = ?";
        $existing_requests_stmt = $conn->prepare($existing_requests_query);
        $existing_requests_stmt->bind_param("s", $student_roll_number);
        $existing_requests_stmt->execute();
        $existing_requests_result = $existing_requests_stmt->get_result();

        while ($row = $existing_requests_result->fetch_assoc()) {
            $unique_course_ids[] = $row['course_id'];
        }

        // Insert course requests into the requestcourses table
        $insert_query = "INSERT INTO requestcourses (student_roll_number, course_id) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_query);

        foreach ($requested_courses as $course_id) {
            // Check if the student has already requested this course
            if (!in_array($course_id, $unique_course_ids)) {
                $insert_stmt->bind_param("si", $student_roll_number, $course_id);
                $insert_stmt->execute();
            } else {
                // Course request already exists, display a message
                echo "You have already requested this course: " . $course_id . "<br>";
                echo '<script type="text/javascript">
                setTimeout(function(){
                    window.location = "request_courses.php";
                }, 3000);
            </script>';

            }
        }

        $insert_stmt->close();
    }

    $existing_requests_stmt->close();
    $conn->close();
    header("location: request_courses.php");
} else {
    header("location: student_login.php");
}
?>
