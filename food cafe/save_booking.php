<?php
include('db_connection.php');

// Retrieve form data
$f_name = $_POST['f_name'];
$email = $_POST['email'];
$people = $_POST['people'];
$time = $_POST['time'];
$date = $_POST['date'];
$p_no = $_POST['p_no'];

// Insert data into the booking table
$sql = "INSERT INTO booking (f_name, email, people, time, date, p_no) 
        VALUES ('$f_name', '$email', $people, '$time', '$date', '$p_no')";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Booking successfully saved!');
            window.location.href = 'index.html';
          </script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();

?>