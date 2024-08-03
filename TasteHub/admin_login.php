<?php
session_start();

// Define the predefined username and password
$predefined_username = 'admin';
$predefined_password = 'required123';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the entered username and password match the predefined values
    if ($username === $predefined_username && $password === $predefined_password) {
        $_SESSION['loggedin'] = true;
        header('Location: admin_dashboard.php');
        exit;
    } else {
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .login-container h4 {
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: #00796b;
        }
        .login-container input {
            width: calc(100% - 1.5rem);
            padding: 0.75rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .login-container button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 5px;
            background-color: #00796b;
            color: #ffffff;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: #004d40;
        }
        .error-message {
            color: #d32f2f;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h4>Admin Login</h4>
        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
