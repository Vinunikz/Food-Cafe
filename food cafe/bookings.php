<?php
include('db_connection.php');

$result = $conn->query("SELECT * FROM booking");
?>

<h2>Booking Management</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>People</th>
            <th>Time</th>
            <th>Date</th>
            <th>Phone Number</th>
            <th>Actions</th> <!-- Add a column for actions -->
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['f_name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['people']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['p_no']; ?></td>
            <td>
                <a href="edit_booking.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?type=booking&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<h3>Add New Booking</h3>
<form action="add_booking.php" method="POST">
    <label for="f_name">Name:</label>
    <input type="text" id="f_name" name="f_name" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="people">Number of People:</label>
    <input type="number" id="people" name="people" required><br>

    <label for="time">Time:</label>
    <input type="time" id="time" name="time" required><br>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br>

    <label for="p_no">Phone Number:</label>
    <input type="text" id="p_no" name="p_no" required><br>

    <button type="submit">Add Booking</button>
</form>

