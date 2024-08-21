<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login</title>
    <link rel="stylesheet" href="logins.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="navigation.css">
</head>
<body class="custom-page">
    <?php include 'navigation.php';?>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']); // Clear the message after displaying it
    }
    ?>
    <h1>Patient Login</h1>
    <form action="check_patient_login.php" method="post" enctype="multipart/form-data">
        <div class="main">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"required><br>
            <button class="btn" type="submit">Login</button><br>
            <p>NEW USER?<a href="patient registration.html">REGISTER</a>
        </div>
    </form>
</body>
</html>