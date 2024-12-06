<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch project details
    $sql = "SELECT * FROM projects WHERE id = $id";
    $result = $conn->query($sql);
    $project = $result->fetch_assoc();
} else {
    die("Project ID is missing.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies_used = $_POST['technologies_used'];

    // Update project
    $sql = "UPDATE projects SET title = '$title', description = '$description', technologies_used = '$technologies_used' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Project updated successfully!";
        header("Location: admin-panel.php"); // Redirect back to the admin panel
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!-- Edit Project Form -->
<form action="" method="POST">
    <input type="text" name="title" value="<?php echo $project['title']; ?>" required>
    <textarea name="description" required><?php echo $project['description']; ?></textarea>
    <input type="text" name="technologies_used" value="<?php echo $project['technologies_used']; ?>" required>
    <button type="submit">Update Project</button>
</form>
