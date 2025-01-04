<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the insert query
    $insertQuery = "INSERT INTO customers (C_Name, C_Email, C_Password) VALUES ('$username', '$email', '$hashedPassword')";

    // Execute the query
    if ($conn->query($insertQuery) === TRUE) {
        $_SESSION['message'] = "User added successfully!";
        header("Location: admin.php?message=User added successfully!");
        exit();
    } else {
        // Handle errors
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=Error: " . urlencode($conn->error));
        exit();
    }
}
?>
