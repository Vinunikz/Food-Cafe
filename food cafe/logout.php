<?php
session_start();

// Destroy the session.
session_unset();
session_destroy();

// Redirect to the login page with a success message.
header("Location: login.php?logout=success");
exit();
?>
