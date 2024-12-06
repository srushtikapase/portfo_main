<?php
// Include the database connection
include('config.php');

// Fetch all projects from the database
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS file -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            font-size: 36px;
            color: #007bff;
            margin-bottom: 40px;
        }

        h3 {
            font-size: 30px;
            color: #343a40;
            margin-bottom: 30px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .col-lg-6 {
            flex: 0 0 45%;
            box-sizing: border-box;
        }

        .project-box {
            background: #fff;
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .project-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .journal-info {
            text-align: left;
        }

        .journal-txt h4 {
            font-size: 22px;
            color: #007bff;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .journal-txt h4 a {
            text-decoration: none;
            color: inherit;
            transition: color 0.3s ease;
        }

        .journal-txt h4 a:hover {
            color: #0056b3;
        }

        .journal-txt p {
            font-size: 14px;
            line-height: 1.6;
            margin: 8px 0;
            color: #555;
        }

        .add-project-btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-top: 30px;
        }

        .add-project-btn:hover {
            background-color: #45a049;
        }

        .image-container {
            text-align: center;
            margin-top: 20px;
        }

        .project-image {
            width: 100%;
            max-width: 400px;
            cursor: pointer;
            border-radius: 8px;
        }

        .github-link {
            display: block;
            margin-top: 10px;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }

        .github-link:hover {
            color: #0056b3;
        }

        /* Modal Styles for Full-screen View */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
            text-align: center;
        }

        .modal-content {
            margin: auto;
            max-width: 90%;
            max-height: 90%;
            display: block;
        }

        .modal-details {
            color: white;
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            max-width: 800px;
            margin: auto;
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            text-align: left;
            width: 80%;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #ccc;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #fff;
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-lg-6 {
                flex: 0 0 100%;
            }

            h2,
            h3 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

    <h2 class="text-center">Manage Projects</h2>
    <div class="container">
        <h3 class="text-center">Existing Projects</h3>
        <div class="row">
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-lg-6">
                        <div class="project-box">
                            <div class="journal-info">
                                <div class="journal-txt">
                                    <h4>
                                        <a href="project.php?id=<?php echo $row['id']; ?>">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </a>
                                    </h4>
                                    <p><strong>Project by:</strong> Srushti Kapase</p>
                                    <p><strong>Technologies Used:</strong> <?php echo htmlspecialchars($row['technologies_used']); ?></p>
                                    <p><?php echo htmlspecialchars($row['description']); ?></p>

                                    <!-- GitHub Link -->
                                    <?php if (!empty($row['github_link'])) { ?>
                                        <a href="<?php echo $row['github_link']; ?>" class="github-link" target="_blank">View on GitHub</a>
                                    <?php } ?>

                                    <!-- Image and Modal -->
                                    <?php if (!empty($row['image_url'])) { ?>
                                        <div class="image-container">
                                            <img src="<?php echo $row['image_url']; ?>" alt="Project Image" class="project-image" onclick="openModal('<?php echo $row['image_url']; ?>', '<?php echo $row['title']; ?>', '<?php echo $row['description']; ?>', '<?php echo $row['github_link']; ?>')">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            } else { ?>
                <p class="text-center" style="width: 100%; font-size: 18px; color: #888;">No projects found.</p>
            <?php } ?>
        </div>
        
    </div>

    <!-- Full-screen Modal for Project Details -->
    <div id="fullScreenModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-details">
            <h3 id="modalTitle"></h3>
            <p id="modalDescription"></p>
            <a href="" id="githubLink" target="_blank" class="github-link">View on GitHub</a>
            <div id="modalImageContainer"></div>
        </div>
    </div>

    <!-- Close DB connection -->
    <?php $conn->close(); ?>

    <script>
        // Function to open the full-screen modal with project details
        function openModal(imageUrl, title, description, githubLink) {
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalDescription").innerText = description;
            document.getElementById("githubLink").href = githubLink;
            document.getElementById("modalImageContainer").innerHTML = '<img src="' + imageUrl + '" class="modal-content">';

            document.getElementById("fullScreenModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("fullScreenModal");
            modal.style.display = "none";
        }
    </script>

</body>
</html>
