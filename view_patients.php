<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['doctor_id'])) {
    $doctor_id = $_SESSION['doctor_id'];
    $sql = "SELECT * FROM patients WHERE doctor_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $patients = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients details</title>
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
        <h2>Doctor Dashboard</h2>
        <a href="doctor dashboard.php">Profile</a>
        <a href="manage appointments.php">Manage Appointments</a>
        <a href="view_patients.php">View Patients</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content">
<?php
        if(isset($_SESSION['confirm_message']))
        {
            echo '<p style="color: green;">' . $_SESSION['confirm_message'] . '</p>';
            unset($_SESSION['confirm_message']); // Clear the message after displaying it
        }
    ?>
    <h1>Patient Details</h1>
    <?php if (!empty($patients)) { ?>
        <table>
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Date of Birth</th>
                    <th>gender</th>
                    <th>Blood Group</th>
                    <th>medical history</th>
                    <th>Current Medication</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $patient) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($patient['patient_id']); ?></td>
                        <td><?php echo htmlspecialchars($patient['name']); ?></td>
                        <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                        <td><?php echo htmlspecialchars($patient['dob']); ?></td>
                        <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                        <td><?php echo htmlspecialchars($patient['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($patient['medical_history']); ?></td>
                        <td><?php echo htmlspecialchars($patient['current_medication']); ?></td>  
                        <td><a href="medication.php?patient_id=<?php echo $patient['patient_id']; ?>" class="add">ADD Prescription</a></td>                     
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