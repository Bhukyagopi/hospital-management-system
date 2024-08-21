<?php
require_once 'config.php';
$sql="SELECT * from patients;";
if($stmt=$conn->prepare($sql)){
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0)
    {
        $patients=$result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients</title>
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
    <h1>manage Patients</h1>
    <a href="patient registration.html" class="add">Add New Patient</a>
    <table>
        <tr>
            <th>Patient ID</th>
            <th>patient name</th>
            <th>phone number</th>
            <th>email</th>
            <th>D.O.B</th>
            <th>gender</th>
            <th>Blood Group</th>
        </tr>
        <?php
        if(!empty($patients))
        {
            foreach($patients as $patient)
            {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($patient['patient_id']).'</td>';
                echo '<td>' . htmlspecialchars($patient['name']).'</td>';
                echo '<td>' . htmlspecialchars($patient['phone']).'</td>';
                echo '<td>' . htmlspecialchars($patient['email']).'</td>';
                echo '<td>' . htmlspecialchars($patient['dob']).'</td>';
                echo '<td>' . htmlspecialchars($patient['gender']).'</td>';
                echo '<td>' . htmlspecialchars($patient['blood_group']).'</td>';
                echo '</tr>';
            }
        }
        ?>
    </table>
    </div>
</body>
</html>