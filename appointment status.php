<?php
require_once 'config.php';
session_start();
$appointment = [];
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $appointment_id=$_POST['appointment_id'];

    $sql="SELECT * from appointments where appointment_id=?";
    if($stmt=$conn->prepare($sql))
    {
        $stmt->bind_param("s",$appointment_id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0)
        {
            $appointment=$result->fetch_assoc();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>appointment status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="navigation.css">
    <link rel="stylesheet" href="index.css">
    <style>
        body{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            background-image: url("https://img.freepik.com/premium-photo/hospital-room-background_946209-3002.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .container{
            background-color:rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            text-align: center;
            align:center;
            margin-top:100px;
            background-color: transparent;
        }
    </style>
</head>
<body>
<?php include 'navigation.php';?>
<div class="container">
    <h1>Appointment Status</h1>
    <table border=2 , width=100%>
        <tr>
            <th>Appointment id</th>
            <th>patient name</th>
            <th>phone number</th>
            <th>doctor name</th>
            <th>appointment date</th>
            <th>appointment time</th>
            <th>status</th>
        </tr>
        <tr>
            <td align="center"><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['phone']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
            <td align="center"><?php echo htmlspecialchars($appointment['status']); ?></td>
        </tr>
    </table>
    </div>
</body>
</html>