<?php
session_start();
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="SELECT * from doctors where username=?";
    if($stmt=$conn->prepare($sql))
    {
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0)
        {
            $doctor=$result->fetch_assoc();

            if (password_verify($password, $doctor['password'])) 
            {   
                $_SESSION['doctor_id']=$doctor['doctor_id'];
                $_SESSION['username']=$doctor['username'];
                header("location:doctor dashboard.php");
            }
            else{
                echo "invalid username or password1";
            }
        }
        else{
            echo "invalid username or password2";
        }
    }
    else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>