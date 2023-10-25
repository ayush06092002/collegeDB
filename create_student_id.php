<!DOCTYPE html>
<html>

<head>
    <title>Create Student ID</title>
    <link rel="stylesheet" type="text/css" href="create_teacher_id_styles.css">
</head>

<body>
    <div class="container">
        <h2>Create a New Student ID</h2>
        <form action="add_student_id.php" method="post">
            <div class="form-group">
                <label for="student_name">Student Name:</label>
                <input type="text" name="student_name" id="student_name" required>
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" name="department" id="department" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Create Student ID</button>
            <br>
            <br>
            <a href="admin_panel.php" class="btn">Back to Admin Panel</a>
        </form>
    </div>
</body>

</html>