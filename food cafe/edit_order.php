<?php
include('db_connection.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $item_quantity = $_POST['item_quantity'];
    

    $sql = "UPDATE cart SET item_name='$item_name', item_price='$item_price', item_quantity='$item_quantity' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM cart WHERE id='$id'");
    $row = $result->fetch_assoc();
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

<h2>Edit Cart</h2>
<form method="post" action="edit_order.php">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <label for="item_name">Item Name:</label>
    <input type="text" name="item_name" value="<?php echo $row['item_name']; ?>"><br>
    <label for="item_price">Item Price:</label>
    <input type="text" name="item_price" value="<?php echo $row['item_price']; ?>"><br>
    <label for="item_quantity">Item Quantity:</label>
    <input type="text" name="item_quantity" value="<?php echo $row['item_quantity']; ?>"><br>
    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
