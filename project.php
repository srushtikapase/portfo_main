<?php
// Include the database connection
include('config.php');  // Make sure to include your database connection file

// Get the project ID from the URL
if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
} else {
    die("Project ID is missing!");
}

// Fetch the project details from the database
$sql = "SELECT * FROM projects WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $project = $result->fetch_assoc();
    
    // Set the dynamic page title based on the project title
    $pageTitle = htmlspecialchars($project['title']);
    echo "<title>" . $pageTitle . "</title>";  // Set title in the <head> section
} else {
    echo "Project not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Dynamic Title -->
    <title><?php echo $pageTitle; ?></title>  <!-- Title will be set dynamically -->
</head>
<body>
    <h1><?php echo htmlspecialchars($project['title']); ?></h1>
    <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
    <p><strong>Technologies Used:</strong> <?php echo htmlspecialchars($project['technologies_used']); ?></p>
    <p><strong>Created At:</strong> <?php echo $project['created_at']; ?></p>
    
    <!-- Add any additional content you'd like to display -->
</body>
</html>
