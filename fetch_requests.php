<?php
require('db.php');

$query = "SELECT rc.student_roll_number, c.course_name,  i.instructor_name, rc.request_date
          FROM requestcourses rc
          JOIN courses c ON rc.course_id = c.course_id
          JOIN courses_instructors ci ON c.course_name = ci.course_name
          JOIN instructors i ON ci.instructor_id = i.instructor_id";

$result = $conn->query($query);

$requests = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

$conn->close();
?>
