<?php
include 'db_config.php';

// Process registration
if (isset($_POST['register'])) {
    $name = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'user'; // Default role

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-danger'>Email already registered!</div>";
    } else {
        // Insert into the users table
        $insert_query = "INSERT INTO users (name, username, password, role) 
                         VALUES ('$name', '$username', '$password', '$role')";
        if ($conn->query($insert_query) === TRUE) {
            echo "<div class='alert alert-success'>Registration successful! <a href='login.php'>Login</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Register</h2>
        <form action="register.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="register" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
</body>
</html>