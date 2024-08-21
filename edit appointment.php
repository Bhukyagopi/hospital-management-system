<?php
session_start();
require_once "config.php";

$appointment = [];


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    $sql = "SELECT * FROM appointments WHERE appointment_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $appointment = $result->fetch_assoc();
            if($appointment['status']=="canceled")
            {
                $_SESSION['cancel_error']= "Appointment not found!";
                header("location:edit appointment link.php");
                exit();
            }
        } else {
            $_SESSION['id_error']= "Appointment not found!";
            header("location:edit appointment link.php");
        }
    } else {
        $error_message = "Database query failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <link rel="stylesheet" href="navigation.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            margin-top:70px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }

        .value {
            margin-bottom: 15px;
            font-size: 16px;
            color: #333;
            text-align: left;
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="date"], input[type="time"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid black;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            background-color: transparent;
            
        }

        input[type="submit"] {
            width: 100%;
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

    </style>
</head>
<body>
    <?php include 'navigation.php';?>
<div class="container">
<?php
        if(isset($_SESSION['success_message'])) {
            echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
            unset($_SESSION['success_message']); // Clear the message after displaying it
        }
        if(isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // Clear the message after displaying it
        }
    ?>
    <h1>Edit Appointment</h1>
    <form action="update appointment.php" method="post">
        <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($appointment['appointment_id'] ?? ''); ?>">
        <input type="hidden" name="doctor_name" value="<?php echo htmlspecialchars($appointment['doctor_name'] ?? ''); ?>">
        <label for="doctor_name">Doctor Name:</label>
        <div class="value"><?php echo htmlspecialchars($appointment['doctor_name'] ?? ''); ?></div>
        <label for="patient_name">Patient name:</label>
        <input type="text" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name'] ?? ''); ?>" required>
        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($appointment['phone'] ?? ''); ?>" required>
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" name="appointment_date" value="<?php echo htmlspecialchars($appointment['appointment_date'] ?? ''); ?>" required>
        <label for="appointment_time">Appointment Time:</label>
        <input type="time" name="appointment_time" value="<?php echo htmlspecialchars($appointment['appointment_time'] ?? ''); ?>" required>
        <input type="submit" value="Update">
        <label>Note: If you want to change the doctor, cancel the appointment and apply for a new appointment!</label>
    </form>
</div>
</body>
</html>
