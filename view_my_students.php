<?php
session_start();

// Check if the teacher is logged in and has a valid username in the session
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the teacher is not logged in
    header("location: teacher_login.php");
    exit();
}

// Include your database connection code (db.php)
require('db.php');

// Retrieve the teacher's username from the session
$teacher_username = $_SESSION['username'];

// Query to fetch courses taught by the teacher
$course_query = "SELECT c.course_id, c.course_name 
                FROM courses c
                INNER JOIN courses_instructors ci ON c.course_id = ci.course_id
                INNER JOIN teachers t ON t.teacher_id = ci.teacher_id
                WHERE t.username = ?";
$course_stmt = $conn->prepare($course_query);
$course_stmt->bind_param("s", $teacher_username);
$course_stmt->execute();
$course_result = $course_stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Students</title>
    <link rel="stylesheet" type="text/css" href="stylesViewMyStudents.css">

</head>

<body>
    <div class="content">
        <h2>Assigned Courses and Students</h2>
        <?php
        while ($course_row = $course_result->fetch_assoc()) {
            $course_id = $course_row['course_id'];
            $course_name = $course_row['course_name'];

            // Query to fetch students assigned to the course
            $student_query = "SELECT s.student_name, s.roll_number 
                            FROM students s
                            INNER JOIN approved_courses ac ON s.roll_number = ac.student_roll_number
                            WHERE ac.course_name = ?";
            $student_stmt = $conn->prepare($student_query);
            $student_stmt->bind_param("s", $course_name);
            $student_stmt->execute();
            $student_result = $student_stmt->get_result();
        ?>
            <h3><?php echo $course_name; ?></h3>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Roll Number</th>
                </tr>
                <?php
                while ($student_row = $student_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $student_row['student_name'] . "</td>";
                    echo "<td>" . $student_row['roll_number'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        <?php
        }
        ?>
        <a href="teacher_panel.php">Back to Dashboard</a>
    </div>
</body>

</html>