<?php
// save_cart.php
include 'db_connection.php'; // Ensure you include your database connection

if (!isset($_SESSION['customer_id'])) {
    // Generate a new customer ID
    $stmt = $conn->prepare("INSERT INTO customerid () VALUES ()");
    $stmt->execute();
    
    // Get the last inserted ID
    $customerId = $conn->insert_id;
    
    // Store the new customer ID in the session
    $_SESSION['customer_id'] = $customerId;
}

// Get JSON input from JavaScript
$inputData = file_get_contents("php://input");
$cartData = json_decode($inputData, true);

if ($cartData) {
    foreach ($cartData as $item) {
        $customerId = 1; // Replace with the actual customer ID
        $itemName = $item['name'];
        $itemPrice = $item['price'];
        $itemQuantity = $item['quantity'];

        // Prepare and execute the SQL insert query
        $stmt = $conn->prepare("INSERT INTO cart (customer_id, item_name, item_price, item_quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isdi", $customerId, $itemName, $itemPrice, $itemQuantity);
        $stmt->execute();
    }
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid data"]);
}
?>
