<?php
    session_start();
    require_once 'config.php';
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $name = $_POST['name'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $blood_group = $_POST['blood_group'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $emergency_contact_phone = $_POST['emergency_contact_phone'];
        $doctor_id=$_POST['id'];
        $medical_history=$_POST['medical_history'];
        $doctor="SELECT * from doctors where doctor_id=?";

    if($stmt=$conn->prepare($doctor))
    {
        $stmt->bind_param("s",$doctor_id);
        $stmt->execute();
        $result=$stmt->get_result();
        $doctors=$result->fetch_assoc();
    }
    $doctor_name=$doctors['name'];
        
        // File upload
        $photo = "";
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $photo_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_filename = $username . '.' . $photo_extension;
            $photo_path = 'patients/' . $photo_filename;
    
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
                $photo = $photo_path;
            } else {
                die("Error uploading photo.");
            }
        } else {
            die("Error: " . $_FILES['photo']['error']);
        }
        if ($password != $confirm_password) {
            die("Passwords do not match.");
        }
    
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        // Prepare and bind
        $sql ="INSERT INTO patients (username, password, name, dob, gender, blood_group, photo, phone, email, address, emergency_contact_phone,doctor_id,doctor_name,medical_history) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
        if($stmt=$conn->prepare($sql))
        {
            $stmt->bind_param("ssssssssssssss",$username, $hashed_password, $name, $dob, $gender, $blood_group,  $photo, $phone, $email, $address, $emergency_contact_phone,$doctor_id,$doctor_name,$medical_history);
            if($stmt->execute())
            {
                $_SESSION['success_message'] = 'Registration successful. Please login.';
                header("location:patient login.php");
                exit();
            }
            else{
                echo "error occured! ".$stmt->error;
            }
        }
        else{
            echo "error in preparing statements".$conn->error;
        }
    }  
$conn->close();
?>