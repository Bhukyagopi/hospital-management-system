<?php
session_start();
require_once 'config.php';

if (isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];
    
    // Store the appointment ID in the session
    $_SESSION['appointment_id'] = $appointment_id;

    // Update the appointment status to "confirmed"
    $sql = "UPDATE appointments SET status = 'confirmed' WHERE appointment_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $appointment_id);
        if($stmt->execute())
        {
            $_SESSION['confirm_message']="appointment completed";
            header("location:manage appointments.php");
            exit();
        }
    }
} else {
    echo "No appointment ID provided.";
    exit();
}
?>
