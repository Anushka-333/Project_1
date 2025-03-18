<?php
session_start();
include 'db_config.php';

// Handle registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Check if username already exists
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Username already taken!</div>";
    } else {
        // Insert new user into the users table
        $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        if ($conn->query($insert_query) === TRUE) {
            echo "<div class='alert alert-success'>Registration successful! <a href='register_login.php'>Login here</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}

// Handle login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php"); // Redirect to dashboard
        } else {
            echo "<div class='alert alert-danger'>Invalid password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Username not found!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
        }
        .container {
            max-width: 500px;
            padding: 30px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form-title {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .btn-custom {
            background-color: #3498db;
            color: white;
        }
        .btn-custom:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="form-title text-center">Register or Login</h2>

        <!-- Registration Form -->
        <h4 class="mt-4">Register</h4>
        <form action="register_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="register" class="btn btn-custom w-100">Register</button>
            </div>
        </form>

        <hr>

        <!-- Login Form -->
        <h4>Login</h4>
        <form action="register_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>