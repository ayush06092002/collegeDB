<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" type="text/css" href="stylesMain.css">
</head>
<body>
    <div class="container">
        <h2 class="title">Student Login</h2>
        <form action="student_authenticate.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username (Your Roll No.)" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
