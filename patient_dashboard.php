<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: patient_login.php");
    exit();
}

require_once 'config.php';

// Fetch patient details using session patient_id
$patient_id = $_SESSION['patient_id'];

$stmt = $conn->prepare("SELECT * FROM patients WHERE patient_id = ?");
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if patient data is found
if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
} else {
    echo "No patient data found.";
    exit();
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
    <title>Patient Dashboard</title>
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

        .profile-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-section img {
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .profile-section p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }

        .profile-section p strong {
            color: #555;
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
        <div class="profile-section">
            <h1>Welcome, <?php echo htmlspecialchars($patient['name']); ?>!</h1>
            <?php
            $photo_path = htmlspecialchars($patient['photo']);
            echo '<img src="' . $photo_path . '" alt="Profile Picture" style="width:150px;height:150px;">';
            ?>
            <p><strong>Patient ID:</strong> <?php echo htmlspecialchars($patient['patient_id']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($patient['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($patient['dob']); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($patient['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></p>
        </div>
    </div>
</body>
</html>

