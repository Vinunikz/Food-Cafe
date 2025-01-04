<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cuisine = $_POST['cuisine'];
    
    // Handle image upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "INSERT INTO food_beverages (name, description, price, cuisine, image) VALUES ('$name', '$description', $price, '$cuisine', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Item added successfully!";
        header("Location: admin.php?message=Item added successfully!");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=Error: " . urlencode($conn->error));
        exit();
    }
}
?>
