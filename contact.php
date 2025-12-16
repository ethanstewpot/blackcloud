<?php
// Stop bots using honeypot
if (!empty($_POST['website'])) {
    exit("Spam detected.");
}

// Validate required fields
if (
    !isset($_POST['name'], $_POST['email'], $_POST['message'], $_POST['privacy']) ||
    empty(trim($_POST['name'])) ||
    empty(trim($_POST['email'])) ||
    empty(trim($_POST['message']))
) {
    exit("Bitte fülle alle Pflichtfelder aus.");
}

$name    = strip_tags(trim($_POST['name']));
$email   = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$message = strip_tags(trim($_POST['message']));

if (!$email) {
    exit("Ungültige E-Mail-Adresse.");
}

// Email recipient (your email)
$to = "mail@example.com";

// Subject
$subject = "Neue Kontaktanfrage von $name";

// Build email message
$body = "Name: $name\n";
$body .= "E-Mail: $email\n\n";
$body .= "Nachricht:\n$message\n";

// Headers
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";

// Send email
if (mail($to, $subject, $body, $headers)) {
    // Redirect to thank you page
    header("Location: thank-you.html");
    exit;
} else {
    echo "Fehler beim Senden der Nachricht.";
}
?>
