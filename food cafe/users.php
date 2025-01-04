<?php
include('db_connection.php');

$result = $conn->query("SELECT * FROM customers");
?>

<h2>User Management</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th> <!-- Add a column for actions -->
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['C_Id']; ?></td>
            <td><?php echo $row['C_Name']; ?></td>
            <td><?php echo $row['C_Email']; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $row['C_Id']; ?>">Edit</a>

                <a href="delete.php?type=user&id=<?php echo $row['C_Id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<h2>Add New User</h2>
<form action="add_user.php" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Add User</button>
</form>

