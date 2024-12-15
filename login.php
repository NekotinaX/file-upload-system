<?php
session_start();
require 'database/db.php'; // Connecting to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Check if data is entered
    if (!empty($username) && !empty($password)) {
        // Check user in the database
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        if ($stmt) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $stored_password);
                $stmt->fetch();

                // Password verification (without hashing)
                if ($password === $stored_password) {
                    // Successful login
                    $_SESSION['user_id'] = $id;
                    header("Location: dash/index.php");
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "Invalid username!";
            }
            $stmt->close();
        } else {
            $error = "Error in database query.";
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
    <title>Login</title>
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
            color: #1e1e1e;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 10px;
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
        
        <form method="POST">
            <h2>Login Form</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <!-- Login and register buttons -->
            <div class="form-buttons">
                <button type="submit">Login</button>
                <button type="button" onclick="window.location.href='register.php'">Register</button>
            </div>
            
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        </form>

        <!-- Footer with company info and link -->
        <div class="footer">
            <p>&copy; 2024 Company XYZ | <a href="mailto:info@company.com">info@company.com</a></p>
            <p>All rights reserved.</p>
        </div>
    </div>
</body>
</html>
