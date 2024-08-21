<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="logins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="navigation.css">
</head>
<body class="custom-page">
    <?php include 'navigation.php';?>
    <h1>Admin Login</h1>
    <form action="check admin login.php" method="post">
        <div class="main">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button class="btn">Login</button><br>
        </div>
    </form>
</body>
</html>