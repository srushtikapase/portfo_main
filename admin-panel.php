<?php
include 'config.php';  // Include the database connection file

// Handle form submission for projects and certificates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle project form submission
    if (isset($_POST['project_title'])) {
        $title = $conn->real_escape_string($_POST['project_title']);
        $description = $conn->real_escape_string($_POST['project_description']);
        $technologies_used = $conn->real_escape_string($_POST['technologies_used']);
        $github_link = $conn->real_escape_string($_POST['project_github_link']);  // New GitHub link

        // Handle image upload for project
        $target_dir = "uploads/projects/";  // Path for saving uploaded files
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);  // Create directory with proper permissions
        }

        $target_file = $target_dir . basename($_FILES["project_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        if (getimagesize($_FILES["project_image"]["tmp_name"]) === false) {
            echo "File is not an image.";
            exit;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["project_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
            exit;
        }

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;

            // Insert the project into the database, including the GitHub link
            $sql = "INSERT INTO projects (title, description, technologies_used, image_url, github_link) 
                    VALUES ('$title', '$description', '$technologies_used', '$image_url', '$github_link')";

            if ($conn->query($sql) === TRUE) {
                echo "Project added successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your project image.";
        }
    }

    // Handle certificate form submission
    if (isset($_POST['certificate_title'])) {
        $certificate_title = $conn->real_escape_string($_POST['certificate_title']);
        $certificate_description = $conn->real_escape_string($_POST['certificate_description']);
        $github_link = $conn->real_escape_string($_POST['certificate_github_link']);  // New GitHub link for certificate

        // Handle image upload for certificate
        $target_dir = "uploads/certificates/";  // Path for saving uploaded files
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);  // Create directory with proper permissions
        }

        $target_file = $target_dir . basename($_FILES["certificate_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        if (getimagesize($_FILES["certificate_image"]["tmp_name"]) === false) {
            echo "File is not an image.";
            exit;
        }

        // Check file size (limit to 5MB)
        if ($_FILES["certificate_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            exit;
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed.";
            exit;
        }

        // Move the uploaded image to the target directory
        if (move_uploaded_file($_FILES["certificate_image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;

            // Insert the certificate into the database, including the GitHub link
            $sql = "INSERT INTO certificates (title, description, image_url, github_link) 
                    VALUES ('$certificate_title', '$certificate_description', '$image_url', '$github_link')";

            if ($conn->query($sql) === TRUE) {
                echo "Certificate uploaded successfully!";
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your certificate image.";
        }
    }
}

// Fetch all projects
$projectsResult = $conn->query("SELECT * FROM projects");

// Fetch all certificates
$certificatesResult = $conn->query("SELECT * FROM certificates");

// Close the database connection at the end of the script
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Projects & Certificates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Admin Panel</h1>

        <!-- Add New Project Form -->
        <h3>Manage Projects</h3>
        <form action="admin-panel.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="project_title" class="form-label">Project Title</label>
                <input type="text" name="project_title" id="project_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="project_description" class="form-label">Project Description</label>
                <textarea name="project_description" id="project_description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="technologies_used" class="form-label">Technologies Used</label>
                <input type="text" name="technologies_used" id="technologies_used" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="project_github_link" class="form-label">GitHub Link</label>
                <input type="url" name="project_github_link" id="project_github_link" class="form-control" placeholder="Enter GitHub URL" required>
            </div>
            <div class="mb-3">
                <label for="project_image" class="form-label">Project Image</label>
                <input type="file" name="project_image" id="project_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Project</button>
        </form>

        <!-- Display Existing Projects -->
        <h3 class="mt-5">Existing Projects</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Technologies Used</th>
                    <th>GitHub Link</th>
                    <th>Project Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $projectsResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo htmlspecialchars($row['technologies_used']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['github_link']); ?>" target="_blank">View GitHub</a></td>
                        <td>
                            <?php if (isset($row['image_url']) && !empty($row['image_url'])) { ?>
                                <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="Project Image" width="100" height="auto">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td>
                            <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_project.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Add New Certificate Form -->
        <h3 class="mt-5">Manage Certificates</h3>
        <form action="admin-panel.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="certificate_title" class="form-label">Certificate Title</label>
                <input type="text" name="certificate_title" id="certificate_title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="certificate_description" class="form-label">Description</label>
                <textarea name="certificate_description" id="certificate_description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="certificate_github_link" class="form-label">GitHub Link</label>
                <input type="url" name="certificate_github_link" id="certificate_github_link" class="form-control" placeholder="Enter GitHub URL">
            </div>
            <div class="mb-3">
                <label for="certificate_image" class="form-label">Certificate Image</label>
                <input type="file" name="certificate_image" id="certificate_image" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Certificate</button>
        </form>

        <!-- Display Existing Certificates -->
        <h3 class="mt-5">Existing Certificates</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>GitHub Link</th>
                    <th>Certificate Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($certificate = $certificatesResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($certificate['title']); ?></td>
                        <td><?php echo htmlspecialchars($certificate['description']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($certificate['github_link']); ?>" target="_blank">View GitHub</a></td>
                        <td>
                            <?php if (isset($certificate['image_url']) && !empty($certificate['image_url'])) { ?>
                                <img src="<?php echo htmlspecialchars($certificate['image_url']); ?>" alt="Certificate Image" width="100" height="auto">
                            <?php } else { ?>
                                No Image
                            <?php } ?>
                        </td>
                        <td>
                            <a href="edit_certificate.php?id=<?php echo $certificate['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete_certificate.php?id=<?php echo $certificate['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
