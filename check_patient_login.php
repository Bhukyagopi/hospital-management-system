<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM patients WHERE username=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();

            if (password_verify($password, $patient['password'])) {
                $_SESSION['patient_id'] = $patient['patient_id'];
                $_SESSION['username'] = $patient['username'];
                header("Location: patient_dashboard.php");
                exit();
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
