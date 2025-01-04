<?php
session_start();
include('db_connection.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $f_name = $_POST['f_name'];
    $email = $_POST['email'];
    $people = $_POST['people'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $p_no = $_POST['p_no'];

    $sql = "UPDATE booking SET f_name='$f_name', email='$email', people='$people', time='$time', date='$date', p_no='$p_no' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {  // Note: Changed $insertQuery to $sql here
        $_SESSION['message'] = "Booking updated successfully!";
        header("Location: admin.php?message=Booking updated successfully!");
        exit();
    } else {
        // Handle errors
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=Error: " . urlencode($conn->error));
        exit();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM booking WHERE id='$id'");
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="css/edit.css"> <!-- Link to your CSS file -->
</head>
<body>

<h2>Edit Booking</h2>
<form method="post" action="edit_booking.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label for="f_name">Name:</label>
    <input type="text" name="f_name" value="<?php echo $row['f_name']; ?>"><br>
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>
    <label for="people">People:</label>
    <input type="number" name="people" value="<?php echo $row['people']; ?>"><br>
    <label for="time">Time:</label>
    <input type="time" name="time" value="<?php echo $row['time']; ?>"><br>
    <label for="date">Date:</label>
    <input type="date" name="date" value="<?php echo $row['date']; ?>"><br>
    <label for="p_no">Phone Number:</label>
    <input type="text" name="p_no" value="<?php echo $row['p_no']; ?>"><br>
    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
