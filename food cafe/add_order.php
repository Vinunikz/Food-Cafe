<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
    $item_quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);

    // Calculate total price (optional, as it's auto-calculated in the table schema)
    $total_price = $item_price * $item_quantity;

    // Insert the new order into the cart table
    $sql = "INSERT INTO cart (customer_id, item_name, item_price, item_quantity) 
            VALUES ('$customer_id', '$item_name', '$item_price', '$item_quantity')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Order added successfully!";
        header("Location: admin.php?message=Order added successfully!");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=" . urlencode("Error: " . $conn->error));
        exit();
    }
}
?>
