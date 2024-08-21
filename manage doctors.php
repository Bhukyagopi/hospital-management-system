<?php
require_once 'config.php';
session_start();
$sql="SELECT * from doctors";
if($stmt=$conn->prepare($sql))
{
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0)
    {
        $doctors=$result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage_Doctors</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
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
        .edit-btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .edit-btn:hover {
            background-color: #45a049;
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
    <h1>manage doctors</h1>
    <a href="doctor registration.php" class="add">Add New Doctor</a>
    <table>
        <tr>
            <th>doctor ID</th>
            <th>username</th>
            <th>email</th>
            <th>name</th>
            <th>phone number</th>
            <th>specialty</th>
            <th>actions</th>
        </tr>
        <?php
            if(!empty($doctors)){
                foreach ($doctors as $doctor){
                    echo '<tr>';
                    echo '<td>'.htmlspecialchars($doctor['doctor_id']).'</td>';
                    echo '<td>'.htmlspecialchars($doctor['username']).'</td>';
                    echo '<td>'.htmlspecialchars($doctor['email']).'</td>';
                    echo '<td>'.htmlspecialchars($doctor['name']).'</td>';
                    echo '<td>'.htmlspecialchars($doctor['phone_number']).'</td>';
                    echo '<td>'.htmlspecialchars($doctor['specialty']).'</td>';
                    echo '<td><a href="edit doctor.php?id=' . htmlspecialchars($doctor['doctor_id']) . '" class="edit-btn">Edit</a></td>';
                    echo '</tr>';
                }
            }

        ?>
    </table>
    </div>
</body>
</html>