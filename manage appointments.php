<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['doctor_id'])) {
    $doctor_id = $_SESSION['doctor_id'];
    $sql = "SELECT * FROM appointments WHERE doctor_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointments = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            color: #ff9900;
        }

        .sidebar a {
            display: block;
            padding: 15px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            font-size: 18px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .add, .complete {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .add {
            background-color: #4CAF50;
        }
        .add:hover {
            background-color: #45a049;
        }
        .complete {
            background-color: #007bff;
        }
        .complete:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Doctor Dashboard</h2>
        <a href="doctor dashboard.php">Profile</a>
        <a href="manage appointments.php">Manage Appointments</a>
        <a href="view_patients.php">View Patients</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content">
    <h1>Your Appointments</h1>
    
    <?php if (!empty($appointments)) { ?>
        <table>
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['phone']); ?></td>
                        <td>
                            <?php 
                                if ($appointment['status'] == 'scheduled') { 
                            ?>
                                <a href="confirm_appointment.php?appointment_id=<?php echo $appointment['appointment_id']; ?>" class="add">Confirm Appointment</a>
                            <?php 
                                } elseif ($appointment['status'] == 'confirmed') {
                            ?>
                                <a href="complete_appointment.php?appointment_id=<?php echo $appointment['appointment_id']; ?>" class="complete">Complete Appointment</a>
                            <?php 
                                } else { 
                                    echo htmlspecialchars($appointment['status']); 
                                } 
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No appointments found.</p>
    <?php } ?>
    </div>
</body>
</html>
