<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" type="text/css" href="stylesStudentPan.css">
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h2>
                <?php
                session_start();
                if (isset($_SESSION['student_name'])) {
                    echo "Welcome, " . $_SESSION['student_name'] . "!";
                }
                ?>
            </h2>
        </div>
        <div class="content">
            <!-- Sidebar code should be present here -->
            <div class="sidebar">
                <!-- Sidebar navigation menu -->
                <!-- Add your sidebar links here -->
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="request_courses.php">Enroll in Courses</a></li>
                    <li><a href="approved_courses.php">Approved Courses</a></li>
                    <li><a href="#">Marks</a></li>
                    <li><a href="#">Attendance</a></li>
                    <li><a href="logout.php" class="logout-button">Logout</a></li>
                </ul>
            </div>

            <div class="student-info">
                <?php
                if (isset($_SESSION['student_name'])) {
                    echo "<h3>Name: " . $_SESSION['student_name'] . "</h3>";
                    echo "<p>Roll Number: " . $_SESSION['roll_number'] . "</p>";
                    echo "<p>Department: " . $_SESSION['department'] . "</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="scriptStudent.js"></script>
</body>
</html>
