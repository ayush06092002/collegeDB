<?php
session_start();
// Check if the teacher is logged in (teacher ID is stored in the session)
if (isset($_SESSION['teacher_id'])) {
    $teacher_id = $_SESSION['teacher_id'];

    // The rest of your TeacherPanel code here
    // You can use $teacher_id for database queries or other operations
} else {
    // Redirect to the teacher login page if not logged in
    header("Location: teacher_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Teacher Panel</title>
    <link rel="stylesheet" type="text/css" href="stylesTeacherPanel.css">
</head>

<body>
    <div class="container">
        <h2>Welcome, Teacher Name!</h2>
        <div class="menu">
            <ul>
                <li><a href="teacher_panel.php">Home</a></li>
                <li><a href="teacher_students.php">View Students</a></li>
                <li><a href="teacher_marks.php">Enter Marks</a></li>
                <li><a href="teacher_attendance.php">Take Attendance</a></li>
                <li><a href="teacher_timetable.php">Timetable</a></li>
            </ul>
        </div>

        <div class="content">
            <?php
            // Connect to the database using your db.php script
            require('db.php');

            // Assuming you have a teacher ID to identify the teacher
             // Replace with the actual teacher's ID

            // Query to retrieve teacher's name
            $teacher_query = "SELECT teacher_name FROM teachers WHERE teacher_id = ?";
            $teacher_stmt = $conn->prepare($teacher_query);
            $teacher_stmt->bind_param("i", $teacher_id);
            $teacher_stmt->execute();
            $teacher_stmt->bind_result($teacher_name);
            $teacher_stmt->fetch();
            $teacher_stmt->close();

            echo "<h3>Welcome, " . $teacher_name . "!</h3>";

            // You can add content for your Teacher Panel here
            // For example, list students, enter marks, take attendance, or display the timetable

            // Don't forget to close the database connection when you're done
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>
