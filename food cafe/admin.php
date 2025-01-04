<?php
session_start(); // Start the session at the top of the file

// Display the message if it's set
if (isset($_GET['message'])) {
    echo "<script>alert('" . $_GET['message'] . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <div class="nav">
            <button onclick="showSection('users')">User Management</button>
            <button onclick="showSection('orders')">Orders Management</button>
            <button onclick="showSection('bookings')">Booking Management</button>
            <button onclick="showSection('food_beverages')">Food & Beverage Management</button>
            <button onclick="window.location.href='logout.php'">Logout</button> <!-- Logout Button -->
        </div>

        <div id="users" class="section">
            <?php include('users.php'); ?>
        </div>

        <div id="orders" class="section" style="display:none;">
            <?php include('orders.php'); ?>
        </div>

        <div id="bookings" class="section" style="display:none;">
            <?php include('bookings.php'); ?>
        </div>

        <div id="food_beverages" class="section" style="display:none;">
            <?php include('food_beverages.php'); ?>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
