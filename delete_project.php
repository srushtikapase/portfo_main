<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete project
    $sql = "DELETE FROM projects WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Project deleted successfully!";
        header("Location: admin-panel.php"); // Redirect back to the admin panel
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    die("Project ID is missing.");
}
?>
