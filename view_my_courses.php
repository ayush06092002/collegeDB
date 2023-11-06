<?php
session_start();

// Check if the teacher is logged in and has a valid teacher_id in the session
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the teacher is not logged in
    header("location: teacher_login.php");
    exit();
}

require('db.php');

// Retrieve the teacher_id from the session
$teacher_id = $_SESSION['id'];

// Query to fetch courses assigned to the teacher
$query = "SELECT c.course_id, c.course_name, c.course_code, c.department 
          FROM courses c
          INNER JOIN courses_instructors ci ON c.course_id = ci.course_id
          WHERE ci.teacher_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" type="text/css" href="stylesViewTeachCourses.css">
</head>
<body>
    <div class="content">
        <h2>Assigned Courses</h2>
        <table>
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Department</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['course_name'] . "</td>";
                echo "<td>" . $row['course_code'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <a href="teacher_panel.php"><b>Back to Dashboard</b></a>
    </div>
</body>
</html>
