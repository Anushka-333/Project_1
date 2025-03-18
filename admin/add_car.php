<?php include '../db_config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Add New Car</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="car_name" class="form-label">Car Name</label>
                <input type="text" class="form-control" id="car_name" name="car_name" required>
            </div>
            <div class="mb-3">
                <label for="car_model" class="form-label">Car Model</label>
                <input type="text" class="form-control" id="car_model" name="car_model" required>
            </div>
            <div class="mb-3">
                <label for="price_per_day" class="form-label">Price Per Day</label>
                <input type="number" step="0.01" class="form-control" id="price_per_day" name="price_per_day" required>
            </div>
            <div class="text-center">
                <button type="submit" name="add_car" class="btn btn-success">Add Car</button>
            </div>
        </form>

        <?php
        if (isset($_POST['add_car'])) {
            $car_name = $_POST['car_name'];
            $car_model = $_POST['car_model'];
            $price_per_day = $_POST['price_per_day'];

            $query = "INSERT INTO cars (car_name, car_model, price_per_day) VALUES ('$car_name', '$car_model', '$price_per_day')";
            if ($conn->query($query)) {
                echo "<div class='alert alert-success mt-3'>Car added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
            }
        }
        ?>
    </div>
</body>
</html>