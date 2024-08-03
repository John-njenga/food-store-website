<?php
session_start();

// Redirect if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: home.php?username=".$_SESSION['username']);
    exit;
}

// Handle login
if (isset($_POST['login'])) {
    // Establish database connection
    $servername = "localhost"; // Change this to your MySQL server hostname
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $dbname = "taste"; // Change this to your MySQL database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from database
    $sql = "SELECT * FROM tblogin WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, set session variables and redirect
            $_SESSION['username'] = $username;
            header("Location: home.php?username=".$_SESSION['username']);
            exit;
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }

    // Close database connection
    $conn->close();
}

// Handle signup
if (isset($_POST['signup'])) {
    // Establish database connection
    $servername = "localhost"; // Change this to your MySQL server hostname
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $dbname = "taste"; // Change this to your MySQL database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Validate input fields
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into tblogin
    $sql = "INSERT INTO tblogin (username, password, email) VALUES ('$username', '$hashed_password','$email')";

    if ($conn->query($sql) === TRUE) {
        // Signup successful
        echo "<script>alert('Signup successful');</script>";
    } else {
        // Error handling
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login & Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(images/feedbck.jpg);
        }
        
        .container {
            max-width: 400px;
            margin: 150px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .form-group input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .signup-link,
        .login-link {
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container" id="login-container">
    <h2>Login</h2>
    <form id="login-form" method="post" action="">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
            <input type="submit" name="login" value="Login">
        </div>
    </form>
    <div class="signup-link" id="signup-link">Don't have an account? Signup</div>
    <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>
</div>

<div class="container" style="display: none;" id="signup-container">
    <h2>Signup</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
            <input type="password" name="password" placeholder="Password">
        </div>
        
        <div class="form-group">
            <input type="submit" name="signup" value="Signup">
        </div>
        <div class="login-link" id="login-link">Already have an account? Login</div>
    </form>
</div>

<script>
    document.getElementById("signup-link").addEventListener("click", function() {
        document.getElementById("login-container").style.display = "none";
        document.getElementById("signup-container").style.display = "block";
    });

    document.getElementById("login-link").addEventListener("click", function() {
        document.getElementById("signup-container").style.display = "none";
        document.getElementById("login-container").style.display = "block";
    });
</script>

</body>
</html>
