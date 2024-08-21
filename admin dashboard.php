<?php
session_start();
require_once 'config.php';
$doctors_count="SELECT * from doctors";
if($stmt=$conn->prepare($doctors_count))
{
    $stmt->execute();
    $res=$stmt->get_result();
    $doc_count=$res->num_rows;
}

$patients_count="SELECT * from patients";
if($stmt=$conn->prepare($patients_count))
{
    $stmt->execute();
    $res=$stmt->get_result();
    $pat_count=$res->num_rows;
}
$current_date = date("Y-m-d");
$appointments_count="SELECT * from appointments where appointment_date=?";
if($stmt=$conn->prepare($appointments_count))
{
    $stmt->bind_param("s",$current_date);
    $stmt->execute();
    $res=$stmt->get_result();
    $app_count=$res->num_rows;
    if ($res->num_rows > 0) {
        // Fetch all rows and store them in an array
        $appointments = $res->fetch_all(MYSQLI_ASSOC);
    } else {
        $appointments = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .header {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 22px;
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 18px;
            color: #666;
        }

        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
            margin-top: 20px;
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
        <div class="header">
            <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Doctors</h3>
                <p><?php echo htmlspecialchars($doc_count)?></p>
            </div>
            <div class="card">
                <h3>Total Patients</h3>
                <p><?php echo htmlspecialchars($pat_count)?></p>
            </div>
            <div class="card">
                <h3>Appointments Today</h3>
                <p><?php echo htmlspecialchars($app_count)?></p>
            </div>
        </div>

        <div class="table-container">
            <h3>Recent Appointments</h3>
            <table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>phone number</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
                <?php
        // Check if there are any appointments
        if (!empty($appointments)) {
            // Loop through each appointment and display the details
            foreach ($appointments as $appointment) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($appointment['appointment_id']) . '</td>';
                echo '<td>' . htmlspecialchars($appointment['patient_name']) . '</td>';
                echo '<td>' . htmlspecialchars($appointment['phone']) . '</td>';
                echo '<td>' . htmlspecialchars($appointment['doctor_name']) . '</td>';    
                echo '<td>' . htmlspecialchars($appointment['appointment_date']) . '</td>';
                echo '<td>' . htmlspecialchars($appointment['appointment_time']) . '</td>';
                echo '<td>' . htmlspecialchars($appointment['status']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No appointments found for today.</td></tr>';
        }
        ?>
                <!-- Add more rows as needed -->
            </table>
        </div>

        <div class="footer">
            &copy; 2024 Hospital Management System. All rights reserved.
        </div>
    </div>

</body>
</html>
