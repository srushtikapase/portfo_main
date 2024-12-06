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

// SQL query to fetch all data from the certificates table
$sql = "SELECT * FROM `certificates`;";
$result = $conn->query($sql);

// Start the Bootstrap container for the grid layout
echo '<div class="container my-5">';
echo '<div class="row">';  // Start the row for the grid layout

// Check if the query was successful and return rows
if ($result->num_rows > 0) {
    // Output data of each row inside Bootstrap cards
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-md-4 mb-4">';  // 3 cards per row on medium screens
        echo '<div class="card shadow-sm">';
        
        // Display image or default message
        if (!empty($row["image_url"])) {
            echo '<img src="' . $row["image_url"] . '" alt="Certificate Image" class="card-img-top certificate-image" data-bs-toggle="modal" data-bs-target="#certificateModal" data-image="' . $row["image_url"] . '" data-title="' . htmlspecialchars($row["title"]) . '" data-description="' . htmlspecialchars($row["description"]) . '">';
        } else {
            echo '<img src="default-image.jpg" alt="No Image" class="card-img-top certificate-image" data-bs-toggle="modal" data-bs-target="#certificateModal">';
        }

        // Card body
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($row["title"]) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($row["description"]) . '</p>';
        echo '<p class="text-muted">Author: ' . htmlspecialchars($row["author"]) . '</p>';
        echo '</div>';  // End card-body
        echo '</div>';  // End card
        echo '</div>';  // End col-md-4
    }
} else {
    echo '<p class="text-center w-100">No certificates available.</p>';
}

echo '</div>';  // End row
echo '</div>';  // End container

// Close the connection
$conn->close();
?>

<!-- Modal to display image in full screen -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="certificateModalLabel">Certificate Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <img id="modalImage" src="" alt="Certificate Image" class="img-fluid mb-3" />
          <h5 id="modalTitle"></h5>
          <p id="modalDescription"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates Display</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .certificate-image {
            height: 200px;
            object-fit: cover;
            border: 5px solid #333;  /* Solid border with color */
            border-radius: 8px;  /* Optional: Rounded corners */
            padding: 5px;  /* Padding between the image and the border */
            cursor: pointer;  /* Add pointer cursor for interaction */
        }
    </style>
</head>
<body>

<!-- Bootstrap JS and Popper for Modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- JavaScript to populate the modal with data -->
<script>
    // Modal functionality to load image and details when an image is clicked
    var certificateModal = document.getElementById('certificateModal');
    certificateModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var imageUrl = button.getAttribute('data-image'); // Extract image URL
        var title = button.getAttribute('data-title'); // Extract title
        var description = button.getAttribute('data-description'); // Extract description
        
        // Set the modal content
        var modalImage = certificateModal.querySelector('#modalImage');
        var modalTitle = certificateModal.querySelector('#modalTitle');
        var modalDescription = certificateModal.querySelector('#modalDescription');

        modalImage.src = imageUrl; // Set image
        modalTitle.textContent = title; // Set title
        modalDescription.textContent = description; // Set description
    });
</script>

</body>
</html>
