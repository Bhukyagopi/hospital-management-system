<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="appointments.css">
    <link rel="stylesheet" href="navigation.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php include 'navigation.php'; ?>
    <?php
        if (isset($_SESSION['past_date'])) {
        echo '<p style="color: red;">' . $_SESSION['past_date'] . '</p>';
        unset($_SESSION['past_date']); // Clear the message after displaying it
        }
        if (isset($_SESSION['sechedule_success_message'])) {
            echo '<p style="color: green;">' . $_SESSION['sechedule_success_message'] . '</p>';
            unset($_SESSION['sechedule_success_message']); // Clear the message after displaying it
        }
    ?>
    <h1>Schedule Appointment</h1>
    <div class="container">
        <form action="schedule_appointment.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required><br>
            <label for="id">Doctor ID:</label>
            <input type="number" name="id" id="id" required>
            <a href="doctors.php">visit the doctors tab to know the doctor ID</a>
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" required><br>
            <label for="appointment_time">Appointment Time:</label>
            <input type="time" id="appointment_time" name="appointment_time" required><br>
            <button type="submit">Schedule</button>
        </form>
    </div>
</body>
</html>