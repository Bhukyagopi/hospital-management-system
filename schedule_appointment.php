<?php
session_start();
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $name=$_POST['name'];
    $phone=$_POST['phone'];
    $doctor_id=$_POST['id'];
    $appointment_date=$_POST['appointment_date'];
    $appointment_time=$_POST['appointment_time'];

    $appointment_datetime = $appointment_date . ' ' . $appointment_time;

    // Get the current date and time
    $current_datetime = date("Y-m-d H:i:s");

    // Check if the selected appointment time is in the past
    if ($appointment_datetime < $current_datetime) {
        $_SESSION['past_date']= "The selected appointment time is in the past. Please choose a future date and time.";
        header("location:appointments.php");
        exit();
    }
    $checkappointments="SELECT * FROM appointments where doctor_id='$doctor_id'AND appointment_date='$appointment_date'AND appointment_time='$appointment_time'";
    $checkResult = $conn->query($checkappointments);

    if ($checkResult === false) {
        echo "Error checking availability: " . $conn->error;
        exit();
    }

    if ($checkResult->num_rows > 0) {
        echo "The selected doctor is not available at this time. Please choose another time.";
        exit();
    }
    $doctor="SELECT * from doctors where doctor_id=?";
    if($stmt=$conn->prepare($doctor))
    {
        $stmt->bind_param("s",$doctor_id);
        $stmt->execute();
        $result=$stmt->get_result();
        $doctors=$result->fetch_assoc();
    }
    $doctor_name=$doctors['name'];
    $specialty=$doctors['specialty'];
    // Insert appointment into the database
    $sql =  $sql = "INSERT INTO appointments (patient_name, doctor_id,doctor_name,specialty, appointment_date, appointment_time, phone) 
            VALUES ('$name', '$doctor_id','$doctor_name','$specialty', '$appointment_date', '$appointment_time', '$phone')";

    if ($conn->query($sql) === TRUE) {
        $appointment_id = $conn->insert_id;
        $_SESSION['sechedule_success_message']="appointment scheduled successfully! your appointment id is:".$appointment_id;
        header("location:appointments.php");
        exit();
        header("location:appointments.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
    
    
}
?>