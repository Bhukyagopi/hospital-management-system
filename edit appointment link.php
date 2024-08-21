<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment Link</title>
    <link rel="stylesheet" href="navigation.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            display: flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            background-image: url("https://img.freepik.com/premium-photo/hospital-room-background_946209-3002.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            }

        .container {
            background-color: transparent;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);
            width: 300px;
            margin-top:90px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid black;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            background-color:transparent;
            color:black;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include 'navigation.php' ?>
<div class="container">
    <?php
    if(isset($_SESSION['id_error'])){
        echo '<p style="color: red;">' . $_SESSION['id_error'] . '</p>';
            unset($_SESSION['id_error']); // Clear the message after displaying it
        }
        if(isset($_SESSION['cancel_error'])){
            echo '<p style="color: red;">' . $_SESSION['cancel_error'] . '</p>';
                unset($_SESSION['cancel_error']); // Clear the message after displaying it
            }
    ?>
    <form action="edit appointment.php" method="POST"></form>
        <h1>Edit Appointment:</h1>
        <form action="edit appointment.php" method="POST">
            <input type="number" name="appointment_id" placeholder="Enter Appointment ID" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>