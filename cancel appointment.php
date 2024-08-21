<?php
session_start();
require_once 'config.php';
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $appointment_id=$_POST['appointment_id'];
    $cancel="cancelled";
    $sql="UPDATE appointments set status=? where appointment_id=?";
    if($stmt=$conn->prepare($sql))
    {
        $stmt->bind_param("ss",$cancel,$appointment_id);
        if($stmt->execute())
        {
            $_SESSION['cancel']="appointment canceled successfully";
            header("location:cancel appointment link.php");
        }
    }
    else{
        echo $conn->error;
    }
}
?>