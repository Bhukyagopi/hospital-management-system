<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone_number = $_POST['phone'];
    $speciality = $_POST['speciality'];

    // Initialize photo variable
    $photo = "";

    // Check if file was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo_extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_filename = $username . '.' . $photo_extension;
        $photo_path = 'doctors/' . $photo_filename;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path)) {
            $photo = $photo_path;
        } else {
            die("Error uploading photo.");
        }
    } elseif ($_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE) {
        die("Error: " . $_FILES['photo']['error']);
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO doctors (username, password, email, name, specialty, phone_number, photo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssss", $username, $hashed_password, $email, $name, $speciality, $phone_number, $photo);
        if ($stmt->execute()) {
            $doctor_id = $conn->insert_id;
            $_SESSION['success_message'] = "Doctor registered successfully! doctor-id:".$doctor_id;
            header("Location:doctor registration.php");
            exit();
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}
?>
