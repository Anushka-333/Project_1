<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: register_login.php");
    exit();
}

// Fetch available cars
$query = "SELECT * FROM cars WHERE availability='yes'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
        }
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: bold;
            color: #2c3e50;
        }
        .card-body {
            background-color: #f9f9f9;
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
    <div class="container mt-5">
        <h2 class="text-center">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

        <h3 class="mt-5 text-center">Available Cars</h3>
        <div class="row">
            <?php
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card card-custom">';
                echo '<img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Car Image">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['car_name'] . ' (' . $row['car_model'] . ')</h5>';
                echo '<p class="card-text">Price per day: $' . $row['price_per_day'] . '</p>';
                echo '<a href="book_car.php?car_id=' . $row['id'] . '" class="btn btn-custom w-100">Book Now</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>