<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Registration</title>
    <link rel="stylesheet" href="patient registrations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="navigation.css">
</head>
<body>
    <?php include 'navigation.php';?>
    <h1>Patient Registration Form</h1>
    <div class="main">
        <form action="patient registration.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Login Information</legend>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required><br>
            </fieldset>
            <fieldset>
                <legend>Basic Information</legend>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required><br>
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required><br>
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br>
                <label for="blood_group">Blood Group:</label>
                <select id="blood_group" name="blood_group" required>
                    <option value="">Select</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select><br>
                <label for="medical_history">medical history(like diabetes,bp,allergies etc..):</label>
                <textarea id="medical_history" name="medical_history" required></textarea><br>
                <label for="photo">photo:</label>
                <input type="file" name="photo" accept=".jpg, .jpeg" required>
                <label for="id">Doctor ID:</label>
            <input type="number" name="id" id="id" required><br>
            <a href="doctors.php">visit the doctors tab to know the doctor ID</a><br>
            </fieldset>
            <fieldset>
                <legend>Contact Information</legend>
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required><br>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required><br>
                <label for="address">Home Address:</label>
                <textarea id="address" name="address" required></textarea><br>
                <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" required><br>
            </fieldset>
            
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
