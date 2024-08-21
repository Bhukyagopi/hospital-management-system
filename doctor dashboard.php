<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['doctor_id'])) {
    header("Location: doctor_login.php");
    exit();
}

require_once 'config.php';

// Fetch patient details using session patient_id
$doctor_id = $_SESSION['doctor_id'];

$stmt = $conn->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if patient data is found
if ($result->num_rows > 0) {
    // Fetch the patient data
    $doctor = $result->fetch_assoc();
    $_SESSION['doctor_id']=$doctor['doctor_id'];
} else {
    echo "No doctor data found.";
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
    <title>Doctor Dashboard</title>
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

        .section {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .section h2 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
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
        <div class="profile-section">
            <h1>Welcome, Dr. <?php echo htmlspecialchars($doctor['name']); ?>!</h1>
            <?php
            $profile_picture_path = $doctor['photo'];
            if (file_exists($profile_picture_path)) {
                echo '<img src="' . $profile_picture_path . '" alt="Profile Picture" style="width:150px;height:150px;">';
            } else {
                echo '<p>No profile picture available.</p>';
            }
            ?>
            <p><strong>Doctor ID:</strong> <?php echo htmlspecialchars($doctor['doctor_id']); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($doctor['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['email']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($doctor['name']); ?></p>
            <p><strong>Specialty:</strong> <?php echo htmlspecialchars($doctor['specialty']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($doctor['phone_number']); ?></p>

        </div>
    </div>
</body>
</html>

?>