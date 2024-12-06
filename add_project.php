<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies_used = $_POST['technologies_used'];

    $sql = "INSERT INTO projects (title, description, technologies_used)
            VALUES ('$title', '$description', '$technologies_used')";

    if ($conn->query($sql) === TRUE) {
        echo "New project added successfully!";
        header("Location: admin-panel.php"); // Redirect back to the admin panel
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
