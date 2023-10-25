<!DOCTYPE html>
<html>

<head>
    <title>Assign Courses to Teachers</title>
    <link rel="stylesheet" type="text/css" href="create_course_styles.css">
</head>

<body>
    <div class="container">
        <h2>Assign Courses to Teachers</h2>
        <form action="add_teacher.php" method="post">
            <div class="form-group">
                <label for="teacher_username">Teacher Username:</label>
                <input type="text" name="teacher_username" id="teacher_username" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" name="department" id="department" required>
            </div>
            <div class="form-group">
                <label for="is_head">Is Head of Department:</label>
                <input type="checkbox" name="is_head" id="is_head" value="1">
            </div>
            <div class="form-group">
                <label for="assigned_courses">Assign Courses:</label>
                <select name="assigned_courses[]" id="assigned_courses" multiple>
                    <?php
                    // Fetch the list of available courses and their departments from the courses table
                    require('db.php');
                    $courses_sql = "SELECT course_name, department FROM courses";
                    $courses_result = $conn->query($courses_sql);

                    if ($courses_result->num_rows > 0) {
                        while ($row = $courses_result->fetch_assoc()) {
                            echo '<option value="' . $row["course_name"] . '">' . $row["course_name"] . ' (' . $row["department"] . ')</option>';
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <button type="submit" class="btn">Add Teacher</button>
            <br><br>
            <a href="admin_panel.php" class="btn">Back to Admin Panel</a>
        </form>
    </div>
</body>

</html>