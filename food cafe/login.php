<?php
session_start();
// Include the database connection file
include('db_connection.php');

// Check if there is a logout success message.
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    echo "<script>alert('Logout successful!');</script>";
}



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine whether the form was for login or registration
    if (isset($_POST['login'])) {
        // User is trying to login
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check for admin credentials
        if ($email === 'admin@gmail.com' && $password === 'admin123') {
            // Admin login successful
            echo "<script>
                    alert('Admin login successful!');
                    window.location.href = 'admin.php'; // Redirect to admin dashboard
                  </script>";
        } elseif ($email === 'staff@gmail.com' && $password === 'staff123') {
            // Staff login successful
            echo "<script>
                    alert('Staff login successful!');
                    window.location.href = 'staff.php'; // Redirect to staff dashboard
                  </script>";
        } else {
            // Query the database for the email
            $loginQuery = "SELECT * FROM customers WHERE C_Email = '$email'";
            $result = $conn->query($loginQuery);

            // Check if the email exists in the database
            if ($result->num_rows > 0) {
                // Fetch the user data
                $user = $result->fetch_assoc();

                // Verify the hashed password with the one provided
                if (password_verify($password, $user['C_Password'])) {
                    $_SESSION['C_Id'] = $user['C_Id']; // Store the logged-in user ID in the session
                    
                    
                    // If password matches, login success
                    echo "<script>
                            alert('Login successful!');
                            window.location.href = 'index.html'; // Redirect to user dashboard
                          </script>";
                } else {
                    // If password does not match, prompt the user to try again
                    echo "<script>
                            alert('Incorrect password. Please try again.');
                            window.location.href = 'login.php'; // Redirect back to login page
                          </script>";
                }
            } else {
                // If email does not exist, prompt the user to register
                echo "<script>
                        alert('No account found with this email. Please register first.');
                        window.location.href = 'login.php'; // Redirect to registration page
                      </script>";
            }
        }
    } elseif (isset($_POST['register'])) {
        // User is trying to register
        $fullName = mysqli_real_escape_string($conn, $_POST['C_Name']);
        $email = mysqli_real_escape_string($conn, $_POST['C_Email']);
        $password = mysqli_real_escape_string($conn, $_POST['C_Password']);

        // Check if the email is unique
        $emailCheckQuery = "SELECT * FROM customers WHERE C_Email = '$email'";
        $result = $conn->query($emailCheckQuery);

        if ($result->num_rows > 0) {
            // If email exists, show an alert and stop the process
            echo "<script>alert('Email already exists. Please try another one.'); window.location.href = 'login.php';</script>";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new customer data into the database
            $insertQuery = "INSERT INTO customers (C_Name, C_Email, C_Password) 
                            VALUES ('$fullName', '$email', '$hashedPassword')";

            if ($conn->query($insertQuery) === TRUE) {
                // Show a success message if registration is successful
                echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
            } else {
                // Show an error if something goes wrong
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    }

    // Close the database connection
    $conn->close();
}
if (isset($_SESSION['C_Email'])) {
    echo "<input type='hidden' id='user-id' value='" . $_SESSION['C_Email'] . "'>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Website</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <div class="container" id="container">

        <!-- Sign-Up Form -->
        <div class="form-container sign-up">
            <form action="login.php" method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <span>or use your email to register</span>
                <input type="text" name="C_Name" placeholder="Full Name" required>
                <input type="email" name="C_Email" placeholder="Email" required>
                <input type="password" name="C_Password" placeholder="Password" required>
                <button type="submit" name="register">Sign Up</button>
            </form>
        </div>

        <!-- Sign-In Form -->
        <div class="form-container sign-in">
            <form action="login.php" method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                </div>
                <span>or use your email for login</span>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of the site's features.</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>

                <div class="toggle-panel toggle-right">
                    <h1>Hello!</h1>
                    <p>Register with your personal details to use all of the site's features.</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
