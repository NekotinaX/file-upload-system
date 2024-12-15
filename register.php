<?php
session_start();
require 'database/db.php'; // Connecting to the database

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Check if all fields are filled
    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        
        // Check if the password and confirmation match
        if ($password === $confirm_password) {

            // Check if the user already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error = "The username already exists!";
            } else {
                // Save the password as plain text
                $hashed_password = $password;  // The password is not hashed

                // Insert the new user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param('ss', $username, $hashed_password);

                if ($stmt->execute()) {
                    $success = "Registration successful! You can log in now.";
                } else {
                    $error = "Error during registration.";
                }
            }
            $stmt->close();
        } else {
            $error = "Passwords do not match!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('dash/img/login-bag.png') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* Background dimming */
            z-index: -1;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .logo {
            margin-bottom: 20px; /* Space between logo and form */
        }
        .logo img {
            width: 120px; /* Logo width */
            height: auto;
        }
        form {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
        h2 {
            color: #ff9800;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #e0e0e0;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #292929;
            color: #e0e0e0;
            box-sizing: border-box;
        }
        input::placeholder {
            color: #aaa;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff9800;
            border: none;
            border-radius: 5px;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #ffb74d;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
        .form-buttons button {
            width: 48%;
        }
        p {
            text-align: center;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            color: #e0e0e0;
            font-size: 0.9em;
            margin-top: 20px;
        }
        .footer a {
            color: #ff9800;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
 
        <!-- Registration Form -->
        <form method="POST">
            <h2>Registration Form</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            
            <div class="form-buttons">
                <button type="submit">Register</button>
                <button type="button" onclick="window.location.href='login.php'">Login</button>
            </div>

            <!-- Error or success notifications -->
            <?php 
                if (isset($error)) echo "<p class='error' style='color:red;'>$error</p>";
                if (isset($success)) echo "<p class='success' style='color:green;'>$success</p>";
            ?>
        </form>

        <!-- Footer with company info and link -->
        <div class="footer">
            <p>&copy; 2024 Company XYZ | <a href="mailto:info@company.com">info@company.com</a></p>
            <p>All rights reserved.</p>
        </div>
    </div>
</body>
</html>
