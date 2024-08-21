<?php
session_start();

if (!isset($_SESSION['patient_id'])) {
    echo "Patient ID not set in session.";
    exit();
}

require_once 'config.php';

$patient_id = $_SESSION['patient_id']; 

$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$prescription = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
        h1 {
            color: #333;
        }
        .message {
            font-size: 18px;
            color: #555;
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
    <div class="container">
        <h1>Prescription Information</h1>
        <?php
        if ($result->num_rows > 0) {
            // Print the prescription information
            echo "<p class='message'><strong>Current Medication:</strong> " . htmlspecialchars($prescription['current_medication']) . "</p>";
        } else {
            echo "<p class='message'>No prescriptions found.</p>";
        }
        ?>
    </div>
</body>
</html>
