<?php
require_once 'config.php';
$sql="SELECT * from appointments;";
if($stmt=$conn->prepare($sql)){
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0)
    {
        $appointments=$result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
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
        }

        .sidebar a:hover {
            background-color: #575757;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }
        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .add{
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom:20px;
        }
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="admin dashboard.php">Dashboard</a>
        <a href="manage doctors.php">Manage_Doctors</a>
        <a href="admin patients.php">Manage Patients</a>
        <a href="admin appointments.php">Appointments</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content">
    <h1>manage appointments</h1>
    <a href="appointments.php" class="add">New Appointment</a>
    <table>
        <tr>
            <th>appointment ID</th>
            <th>patient name</th>
            <th>phone number</th>
            <th>doctor name</th>
            <th>appointment date</th>
            <th>appointment time</th>
            <th>status</th>
        </tr>
        <?php
        if(!empty($appointments))
        {
            foreach($appointments as $appointment)
            {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($appointment['appointment_id']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['patient_name']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['phone']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['doctor_name']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['appointment_date']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['appointment_time']).'</td>';
                echo '<td>' . htmlspecialchars($appointment['status']).'</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    </div>
</body>
</html>