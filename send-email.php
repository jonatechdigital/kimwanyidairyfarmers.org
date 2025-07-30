<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = filter_var(trim($_POST["Contact-2-First-Name"]), FILTER_SANITIZE_STRING);
    $lastName = filter_var(trim($_POST["Contact-2-Last-Name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["Contact-2-Email-2"]), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST["Contact-2-Phone"]), FILTER_SANITIZE_STRING);
    $role = isset($_POST["Contact-2-Radio"]) ? filter_var(trim($_POST["Contact-2-Radio"]), FILTER_SANITIZE_STRING) : "Not specified";
    $message = filter_var(trim($_POST["Contact-2-Message"]), FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Handle invalid email address
        http_response_code(400);
        echo "Please provide a valid email address.";
        exit;
    }

    // Recipient email
    $to = "info@kimwanyidairyfarmers.org";

    // Email subject
    $subject = "New Partnership Inquiry from " . $firstName . " " . $lastName;

    // Email content
    $email_content = "You have received a new message from your website contact form.\n\n";
    $email_content .= "First Name: $firstName\n";
    $email_content .= "Last Name: $lastName\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone Number: $phone\n";
    $email_content .= "Role in Partnership: $role\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: " . $firstName . " " . $lastName . " <" . $email . ">";

    // Send the email
    if (mail($to, $subject, $email_content, $headers)) {
        // Redirect to a 'thank you' page
        header("Location: thank-you.html");
        exit;
    } else {
        // Handle mail sending failure
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
        exit;
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
    exit;
}
?>