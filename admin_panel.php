<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="stylesAdminn.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Welcome, Admin <?php echo $_SESSION['username']; ?></h2>
        </div>
        <div class="actions">
            <h3>You can perform the following actions:</h3>
            <ul>
                <li><a href="create_teacher_id.php" class="btn">Create Teacher ID</a></li>
                <li><a href="create_student_id.php" class="btn">Create Student ID</a></li>
                <li><a href="create_course.php" class="btn">Create Course</a></li>
                <li><a href="create_teacher.php" class="btn">Assign Teachers' Courses</a></li>
                <li><a href="approve_course_request.php" class="btn">Approve Students' Course Request</a></li>
                <li><a href="manage.php" class="btn">Manage System</a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="logout.php" class="btn logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
