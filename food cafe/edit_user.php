<?php
session_start(); // Start the session
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM customers WHERE C_Id = $id");
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $sql = "UPDATE customers SET C_Name='$username', C_Email='$email' WHERE C_Id=$id";

    if ($conn->query($sql) === TRUE) {  // Note: Changed $insertQuery to $sql here
        $_SESSION['message'] = "User updated successfully!";
        header("Location: admin.php?message=User updated successfully!");
        exit();
    } else {
        // Handle errors
        $_SESSION['message'] = "Error: " . $conn->error;
        header("Location: admin.php?message=Error: " . urlencode($conn->error));
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link rel="stylesheet" href="css/edit.css"> <!-- Link to your CSS file -->
</head>
<body>

<h2>Edit User</h2>
<form action="edit_user.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $user['C_Id']; ?>">
    <input type="text" name="username" value="<?php echo $user['C_Name']; ?>">
    <input type="email" name="email" value="<?php echo $user['C_Email']; ?>">
    <button type="submit">Update</button>
</form>

</body>
</html>