<!DOCTYPE html>
<html>

<head>
    <title>Request Courses</title>
    <link rel="stylesheet" type="text/css" href="stylesRequestCourses.css">
</head>

<body>
    <div class="container">
        <h2>Request Courses</h2>
        <p>Select the courses you want to request:</p>

        <form method="post" action="process_request.php">
            <ul class="course-list">
                <?php
                session_start();

                if (isset($_SESSION['student_name']) && isset($_SESSION['roll_number'])) {
                    // Fetch courses available for the student's department
                    require('db.php');

                    $student_department = $_SESSION['department'];
                    $query = "SELECT course_id, course_name, department FROM courses WHERE department = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("s", $student_department);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo '<li>';
                        echo '<input type="checkbox" name="courses[]" value="' . $row['course_id'] . '"> ';
                        echo $row['course_name'];
                        echo '</li>';
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>
            </ul>

            <button type="submit">Request Courses</button>
            <br><br>
            <a href="student_panel.php" class="btn">Back to Student Panel</a>
        </form>
    </div>

    <script src="scriptRequestCourses.js"></script>
</body>

</html>
