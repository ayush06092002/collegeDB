<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="stylesMain.css">
</head>
<body>
    <div class="container">
        <h2 class="title">User Registration</h2>
        <form action="register_process.php" method="post">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="is_admin">Register as Admin:</label>
                <input type="checkbox" name="is_admin" id="is_admin" value="1">
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Register</button>
            </div>
        </form>
    </div>
</body>
</html>
