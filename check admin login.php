<?php
session_start();
require_once 'config.php';
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $username=$_POST['username'];
    $password=$_POST['password'];

    $sql="SELECT * from admin where username=?";
    if($stmt=$conn->prepare($sql))
    {
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows>0)
        {
            $admin=$result->fetch_assoc();

            if($password==$admin['password'])
            {   
                $_SESSION['admin_id']=$admin['admin_id'];
                $_SESSION['username']=$admin['username'];
                $_SESSION['time']=$admin['created_at'];
                header("location:admin dashboard.php");
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