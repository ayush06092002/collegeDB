<!DOCTYPE html>
<html>
<head>
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" type="text/css" href="stylesTeacherPanell.css">
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h2>
                <?php
                session_start();
                if (isset($_SESSION['username'])) {
                    echo "Welcome, " . $_SESSION['teacher_name'] . "!";
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
                    <li><a href="view_my_courses.php">View My Courses</a></li>
                    <li><a href="view_my_students.php">View My Students</a></li>
                    <li><a href="#">Grades</a></li>
                    <li><a href="logout.php" class="logout-button">Logout</a></li>
                </ul>
            </div>

            <div class="teacher-info">
                <?php
                if (isset($_SESSION['username'])) {
                    echo "<h3>ID: " . $_SESSION['id'] . "</h3>";
                    // Add other teacher information as needed
                }
                ?>
            </div>
        </div>
    </div>
    <script src="scriptTeacher.js"></script>
</body>
</html>
