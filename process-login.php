<?php
// Hardcoded credentials for admin
$validUsername = "admin";
$validPassword = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials
    if ($username === $validUsername && $password === $validPassword) {
        // Redirect to admin panel
        header("Location: admin-panel.php");
        exit();
    } else {
        // Redirect back to login page with error message
        echo "<script>alert('Invalid username or password'); window.location.href='login.php';</script>";
    }
}
?>
