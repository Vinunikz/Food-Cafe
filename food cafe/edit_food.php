<?php
session_start();
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM food_beverages WHERE id = $id");
    $item = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $cuisine = $_POST['cuisine'];
    
    // Handle image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;
    } else {
        $image = $item['image']; // Keep the old image if none is uploaded
    }

    $sql = "UPDATE food_beverages SET name='$name', description='$description', price=$price, cuisine='$cuisine', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {  // Note: Changed $insertQuery to $sql here
        $_SESSION['message'] = "Item updated successfully!";
        header("Location: admin.php?message=Item updated successfully!");
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

<form action="edit_food.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
    
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $item['name']; ?>" required>

    <label>Description:</label>
    <input type="text" name="description" value="<?php echo $item['description']; ?>" required>

    <label>Price:</label>
    <input type="number" name="price" value="<?php echo $item['price']; ?>" required>

    <label>Cuisine:</label>
    <select name="cuisine" required>
        <option value="Sri Lankan" <?php echo ($item['cuisine'] == 'Sri Lankan') ? 'selected' : ''; ?>>Sri Lankan</option>
        <option value="American" <?php echo ($item['cuisine'] == 'American') ? 'selected' : ''; ?>>American</option>
        <option value="French" <?php echo ($item['cuisine'] == 'French') ? 'selected' : ''; ?>>French</option>
        <option value="British" <?php echo ($item['cuisine'] == 'British') ? 'selected' : ''; ?>>British</option>
        <option value="Italian" <?php echo ($item['cuisine'] == 'Italian') ? 'selected' : ''; ?>>Italian</option>
    </select>

    <label>Image:</label>
    <input type="file" name="image" accept="image/*">
    <img src="<?php echo $item['image']; ?>" alt="" style="width: 100px;">

    <button type="submit">Update Item</button>
</form>

</body>
</html>


