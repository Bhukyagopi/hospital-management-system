<?php
require_once 'config.php';
session_start();

$sql = "SELECT * FROM doctors";
if ($stmt = $conn->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();
    $doctors = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="navigation.css">
    <style>
        body {       
            background-color: #eef2f5;
            background-image: url("https://img.freepik.com/premium-photo/hospital-room-background_946209-3002.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding-top:20px;
            
        }
        .doctor-card {
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
            padding: 20px;
            
        }
        .doctor-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 4px solid #007bff;
        }
        .doctor-card h3 {
            margin: 10px 0;
            font-size: 22px;
            color: #333;
        }
        .doctor-card p {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        .doctor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <?php include 'navigation.php'; ?>
    <div class="container">
        <?php
        foreach ($doctors as $doctor) {
            $photo_path = htmlspecialchars($doctor['photo']);
            $id = htmlspecialchars($doctor['doctor_id']);
            $name = htmlspecialchars($doctor['name']);
            $specialty = htmlspecialchars($doctor['specialty']);
            
            echo "<div class='doctor-card'>";
            echo "<img src='$photo_path' alt='Profile Picture'>";
            echo "<h3>$name</h3>";
            echo "<p>ID: $id</p>";
            echo "<p>Specialty: $specialty</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
