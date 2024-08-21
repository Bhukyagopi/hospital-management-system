<?php
require_once "config.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $appointment_id = $_POST['appointment_id'];
    $patient_name = $_POST['patient_name'];
    $phone = $_POST['phone'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $doctor_id = $_POST['id'];

    $appointment_datetime = $appointment_date . ' ' . $appointment_time;

    // Get the current date and time
    $current_datetime = date("Y-m-d H:i:s");

    // Check if the selected appointment time is in the past
    if ($appointment_datetime < $current_datetime) {
        $_SESSION['error']="The selected appointment time is in the past. Please choose a future date and time.";
        header("location:edit appointment.php");
        exit();
    }

    // Check if the doctor is available at the new time, ignoring the current appointment's existing date and time
    $checkappointment = "SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND appointment_id != ?";
    if ($stmt = $conn->prepare($checkappointment)) {
        $stmt->bind_param("sssi", $doctor_id, $appointment_date, $appointment_time, $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['error']="The selected doctor is not available at this time. Please choose another time.";
            header("location:edit appointment.php");
            exit();
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Update the appointment in the database
    $sql = "UPDATE appointments SET patient_name = ?, phone = ?, appointment_date = ?, appointment_time = ? WHERE appointment_id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", $patient_name, $phone, $appointment_date, $appointment_time, $appointment_id);
        if ($stmt->execute()) {
            $_SESSION['success_message']="Appointment updated successfully.";
            header("location:edit appointment.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
