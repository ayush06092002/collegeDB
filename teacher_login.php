<!DOCTYPE html>
<html>
<head>
    <title>Teacher Login</title>
    <link rel="stylesheet" type="text/css" href="stylesMain.css">
</head>
<body>
    <div class="container">
        <h2 class="title">Teacher Login</h2>
        <form action="teacher_authenticate.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
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
