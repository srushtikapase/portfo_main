<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";  // Default password is empty for XAMPP
$dbname = "phpmyadmin1";  // Change this to the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the certificate ID from the URL
$id = $_GET['id'];

// Fetch the certificate details
$sql = "SELECT * FROM certificates WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Check if certificate exists
if (!$row) {
    echo "Certificate not found!";
    exit;
}

// Handle form submission for updating the certificate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $_POST['author'];

    // Update the certificate in the database
    $updateSql = "UPDATE certificates SET title = '$title', description = '$description', author = '$author' WHERE id = $id";
    
    if ($conn->query($updateSql) === TRUE) {
        echo "Certificate updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<form method="POST" action="">
    <label for="title">Title:</label>
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br><br>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $row['description']; ?></textarea><br><br>

    <label for="author">Author:</label>
    <input type="text" name="author" value="<?php echo $row['author']; ?>" required><br><br>

    <button type="submit">Update Certificate</button>
</form>

<?php
$conn->close();
?>
