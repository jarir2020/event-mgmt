<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="frontend/css/login.css"> 
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a style="text-decoration: none;" href="register.php">Register here</a></p>
        <p>For Events <a style="text-decoration: none;" href="events.php">Click here</a></p>
    </div>
</body>
</html>