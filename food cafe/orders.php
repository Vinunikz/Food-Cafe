<?php
include('db_connection.php');

$result = $conn->query("SELECT * FROM cart");
?>

<h2>Orders Management</h2>
<table>
    <thead>
        <tr>
        <th>ID</th>
            <th>Customer ID</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Item Quantity</th>
            <th>Total Price</th> <!-- Display calculated total price -->
            <th>Actions</th> <!-- Column for actions -->
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
        <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['customer_id']; ?></td>
            <td><?php echo $row['item_name']; ?></td>
            <td><?php echo $row['item_price']; ?></td>
            <td><?php echo $row['item_quantity']; ?></td>
            <td><?php echo $row['total_price']; ?></td> <!-- Output total price -->
            <td>
                <a href="edit_order.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?type=order&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<h3>Add New Order</h3>
<form action="add_order.php" method="POST">
    <label for="customer_id">Customer ID:</label>
    <input type="number" id="customer_id" name="customer_id" required><br>

    <label for="item_name">Item Name:</label>
    <input type="text" id="item_name" name="item_name" required><br>

    <label for="item_price">Item Price:</label>
    <input type="number" step="0.01" id="item_price" name="item_price" required><br>

    <label for="item_quantity">Item Quantity:</label>
    <input type="number" id="item_quantity" name="item_quantity" required><br>

    <button type="submit">Add Order</button>
</form>