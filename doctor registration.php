<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin-top:30px;
        }

        .container {
            background-color: #fff;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
            margin: 20px;
            box-sizing: border-box;
            margin-top:30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            margin-top:30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 1.1em;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="password"],
        input[type="file"] {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Doctor Registration</h2>
        <form action="register doctor.php" method="post" enctype="multipart/form-data">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Password</label>
    <input type="password" name="password" id="password" required><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required><br>

    <label for="name">Name</label>
    <input type="text" name="name" id="name" required><br>

    <label for="speciality">Speciality</label>
    <input type="text" name="speciality" id="speciality" required><br>

    <label for="phone">Phone</label>
    <input type="text" name="phone" id="phone" required><br>

    <label for="photo">Profile Picture</label>
    <input type="file" name="photo" id="photo" accept="image/*"><br>

    <input type="submit">
    <?php
            if(isset($_SESSION['success_message']))
            {
                echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']);
            }
        ?>
</form>

    </div>
</body>
</html>
