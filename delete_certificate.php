<?php
include 'config.php';  // Include the database connection file

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the certificate from the database
    $sql = "DELETE FROM certificates WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Certificate deleted successfully!";
        header("Location: admin-panel.php");  // Redirect back to the admin panel
    } else {
        echo "Error deleting certificate: " . $conn->error;
    }
}

$conn->close();  // Close the database connection
?>
