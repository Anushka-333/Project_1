<?php
session_start();
include 'db_config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: register_login.php");
    exit();
}

// Fetch car details
$car_id = $_GET['car_id'];
$query = "SELECT * FROM cars WHERE id='$car_id' AND availability='yes'"; // Only fetch available cars
$car_result = $conn->query($query);

if ($car_result->num_rows == 0) {
    // If car is not available, show a message and exit
    echo "<div class='alert alert-danger'>Sorry, this car is no longer available.</div>";
    exit();
}

$car = $car_result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Calculate total price
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);
    $days = ($end_timestamp - $start_timestamp) / (60 * 60 * 24);
    $total_price = $days * $car['price_per_day'];

    // Insert booking into the database
    $user_id = $_SESSION['user_id'];
    $insert_query = "INSERT INTO bookings (user_id, car_id, start_date, end_date, total_price) 
                     VALUES ('$user_id', '$car_id', '$start_date', '$end_date', '$total_price')";
    if ($conn->query($insert_query) === TRUE) {
        // Update the availability of the car to 'no'
        $update_query = "UPDATE cars SET availability='no' WHERE id='$car_id'";
        if ($conn->query($update_query) === TRUE) {
            echo "<div class='alert alert-success'>Booking successful! Total price: $$total_price</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating car availability: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car</title>
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
        <h2 class="text-center">Book <?php echo $car['car_name']; ?></h2>
        <form action="book_car.php?car_id=<?php echo $car['id']; ?>" method="POST">
            <div class="card card-custom">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                    <button type="submit" class="btn btn-custom w-100">Book Now</button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>