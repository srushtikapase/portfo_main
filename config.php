<?php
$host = 'localhost';      // Database host
$user = 'root';           // Database user (for XAMPP, it's usually 'root')
$pass = '';               // Database password (default is empty for XAMPP)
$dbname = 'phpmyadmin1';  // The name of your database

// Create a connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Display error if connection fails
} else {
    // Optional: Print success message for debugging (You can remove this line later)
    // echo "Connected successfully";
}
?>
<?php
// config.php
$servername = "localhost";  // Typically 'localhost' for local development
$username = "root";         // Default username for XAMPP is 'root'
$password = "";             // Default password is empty for XAMPP
$dbname = "phpmyadmin1";    // Ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // Display error if connection fails
}
?>

