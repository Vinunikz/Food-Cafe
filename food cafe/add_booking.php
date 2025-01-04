<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $f_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $people = mysqli_real_escape_string($conn, $_POST['people']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $p_no = mysqli_real_escape_string($conn, $_POST['p_no']);

    // Insert the new booking into the database
    $sql = "INSERT INTO booking (f_name, email, people, time, date, p_no) 
            VALUES ('$f_name', '$email', '$people', '$time', '$date', '$p_no')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Booking added successfully!";
        header("Location: admin.php?message=Booking added successfully!");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=Error: " . urlencode($conn->error));
        exit();
    }
}
?>
