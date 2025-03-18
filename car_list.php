<?php include 'db_config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Available Cars</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Car Name</th>
                    <th>Model</th>
                    <th>Price/Day</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM cars WHERE availability='yes'";
                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['car_name']}</td>
                            <td>{$row['car_model']}</td>
                            <td>\${$row['price_per_day']}</td>
                            <td>{$row['availability']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>