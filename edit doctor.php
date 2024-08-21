<?php
require_once 'config.php';
session_start();

// Step 1: Capture the ID from the URL
if(isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $doctor_id = trim($_GET['id']);

    // Step 2: Retrieve the Doctor's Details Using the ID
    $sql = "SELECT * FROM doctors WHERE doctor_id = ?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $doctor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1) {
            $doctor = $result->fetch_assoc();
        } else {
            // Redirect if no doctor found
            header("location: manage_doctors.php");
            exit();
        }
    } else {
        echo "Error: Could not prepare statement";
    }
} else {
    // Redirect if no ID provided
    header("location: manage_doctors.php");
    exit();
}

// Step 4: Handle Form Submission for Update
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $phone_number = $_POST['phone'];
    $speciality = $_POST['speciality'];

    $sql = "UPDATE doctors SET username=?, email=?, name=?, phone_number=?, specialty=? WHERE doctor_id=?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssi", $username, $email, $name, $phone_number, $speciality, $doctor_id);
        if($stmt->execute()) {
            $_SESSION['success_message'] = "Doctor details updated successfully!";
            header("location: manage_doctors.php");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
    } else {
        echo "Error: Could not prepare statement";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"],
        input[type="number"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        button {
            padding: 12px;
            border: none;
            border-radius: 4px;
            color: black;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Doctor Details</h1>
        <form action="edit_doctor.php?id=<?php echo $doctor_id; ?>" method="POST" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($doctor['username']); ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>

            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>

            <label for="speciality">Speciality</label>
            <input type="text" name="speciality" id="speciality" value="<?php echo htmlspecialchars($doctor['specialty']); ?>" required>

            <label for="phone">Phone Number</label>
            <input type="number" name="phone" id="phone" value="<?php echo htmlspecialchars($doctor['phone_number']); ?>" required>

            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" accept="image/*">
            
            <button type="submit">Update Doctor</button>
        </form>
    </div>
</body>
</html>
