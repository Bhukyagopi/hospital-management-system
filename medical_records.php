<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

require_once 'config.php';

// Fetch medical records for the logged-in patient
$patient_id = $_SESSION['patient_id'];

$stmt = $conn->prepare("SELECT * FROM medical_records WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all records if found
$records = [];
if ($result->num_rows > 0) {
    $records = $result->fetch_all(MYSQLI_ASSOC);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .add {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
<div class="sidebar">
        <h2>Patient Dashboard</h2>
        <a href="patient_dashboard.php">Profile</a>
        <a href="doctor_details.php">My Doctor</a>
        <a href="medical_records.php">Medical Records</a>
        <a href="prescription.php">Prescriptions</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="main-content">
    <h1>Medical Records</h1>
    <?php if (!empty($records)) { ?>
        <table>
            <tr>
                <th>Record ID</th>
                <th>Patient ID</th>
                <th>Doctor ID</th>
                <th>Prescription</th>
                <th>Prescription Time</th>
            </tr>
            <?php foreach ($records as $record) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($record['record_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['patient_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['doctor_id']); ?></td>
                    <td><?php echo htmlspecialchars($record['prescription']); ?></td>
                    <td><?php echo htmlspecialchars($record['created_date']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No medical records found.</p>
    <?php } ?>
    </div>
</body>
</html>