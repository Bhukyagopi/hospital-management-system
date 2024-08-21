<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['patient'])) {
        $patient_id = $_SESSION['patient'];
        $prescription = $_POST['prescription'];
        $doctor_id = $_SESSION['doctor_id']; // Assuming the doctor is logged in and stored in the session

        // Start transaction
        $conn->begin_transaction();

        try {
            // Update the prescription in the patients table
            $sql = "UPDATE patients SET current_medication = ? WHERE patient_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $prescription, $patient_id);
            $stmt->execute();

            // Insert the prescription into the medical_records table
            $sql = "INSERT INTO medical_records (patient_id, doctor_id, prescription) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $patient_id, $doctor_id, $prescription);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            $_SESSION['confirm_message'] = "Prescription added successfully.";
            header("Location: view_patients.php");
            exit();
        } catch (Exception $e) {
            // Rollback transaction if any error occurs
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "No patient ID found in session.";
        exit();
    }
} elseif (isset($_GET['patient_id'])) {
    // Store the patient ID in the session
    $_SESSION['patient'] = $_GET['patient_id'];
} else {
    echo "No patient ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #666666;
        }

        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            margin-bottom: 20px;
            resize: none;
            font-size: 14px;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            color: #4CAF50;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Add Prescription</h1>
        <form action="medication.php" method="post">
            <label for="prescription">Add Prescription:</label>
            <textarea name="prescription" id="prescription" required></textarea>
            <button type="submit">Add Prescription</button>
        </form>
    </div>
</body>
</html>
