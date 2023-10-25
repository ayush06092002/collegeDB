<!DOCTYPE html>
<html>

<head>
    <title>Create Course</title>
    <link rel="stylesheet" type="text/css" href="create_course_styles.css">
</head>

<body>
    <div class="container">
        <h2>Create a New Course</h2>
        <form action="add_course.php" method="post">
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" name="department" id="department" required>
            </div>
            <div class="form-group">
                <label for="course_name">Course Name:</label>
                <input type="text" name="course_name" id="course_name" required>
            </div>
            <div class="form-group">
                <label for="course_code">Course Code:</label>
                <input type="text" name="course_code" id="course_code" required>
            </div>
            <button type="submit" class="btn">Add Course</button>
        </form>
        <br>
        <a href="admin_panel.php" class="btn">Back to Admin Panel</a>
    </div>
</body>

</html>