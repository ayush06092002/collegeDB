<!DOCTYPE html>
<html>
<head>
    <title>Create Teacher ID</title>
    <link rel="stylesheet" type="text/css" href="create_teacher_id_styles.css">
</head>
<body>
    <div class="container">
        <h2>Create a Teacher ID</h2>
        <form action="add_teacher_id.php" method="post">
            <div class="form-group">
                <label for="teacher_name">Teacher Name:</label>
                <input type="text" name="teacher_name" id="teacher_name" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Create Teacher ID</button>
        </form>
        <br>
        <a href="admin_panel.php" class="btn">Back to Admin Panel</a>
    </div>
</body>
</html>
