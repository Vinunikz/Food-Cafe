<?php
include('db_connection.php');

// Fetch current items
$result = $conn->query("SELECT * FROM food_beverages");
?>


<h2>Food & Beverage Management</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Cuisine</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>Rs.<?php echo $row['price']; ?></td>
            <td><?php echo $row['cuisine']; ?></td>
            <td><img src="<?php echo $row['image']; ?>" alt="" style="width: 100px;"></td>
            <td>
                <a href="edit_food.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?type=food&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<h3>Add New Food/Beverage</h3>
<form action="add_food.php" method="POST" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" required>

    <label>Description:</label>
    <input type="text" name="description" required>

    <label>Price:</label>
    <input type="number" name="price" required>

    <label>Cuisine:</label>
    <select name="cuisine" required>
        <option value="Sri Lankan">Sri Lankan</option>
        <option value="American">American</option>
        <option value="French">French</option>
        <option value="British">British</option>
        <option value="Italian">Italian</option>
    </select>

    <label>Image:</label>
    <input type="file" name="image" accept="image/*" required>

    <button type="submit">Add Item</button>
</form>
