<?php
include('db_connection.php');

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = $_GET['id'];

    switch ($type) {
        case 'booking':
            $sql = "DELETE FROM booking WHERE id='$id'";
            break;
        case 'order':
            $sql = "DELETE FROM cart WHERE id='$id'";
            break;
        case 'user':
            $sql = "DELETE FROM customers WHERE C_Id='$id'";
            break;
        case 'food':
            $sql = "DELETE FROM food_beverages WHERE id='$id'";
            break;
        default:
            echo "Invalid type";
            exit;
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>
