<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Email recipient
    $to = 'srushtikapase2004@gmail.com';

    // Email subject
    $email_subject = 'New message from website: ' . $subject;

    // Email content
    $email_body = "You have received a new message from your website contact form.\n\n" .
        "Name: $name\n" .
        "Email: $email\n" .
        "Message:\n$message";

    // Email headers
    $headers = "From: $email\n";
    $headers .= "Reply-To: $email";

    // Send the email
    mail($to, $email_subject, $email_body, $headers);

    // Redirect back to the contact page after sending the email
    header('Location: /contact.html?success=true');
} else {
    // Handle any other requests (GET, etc.)
    header('Location: /contact.html');
}
?>
