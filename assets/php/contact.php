
<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = htmlspecialchars(trim($_POST["name"] ?? ''), ENT_QUOTES, 'UTF-8');
    $clientEmail = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"] ?? ''), ENT_QUOTES, 'UTF-8');
    $honeypot = trim($_POST["company"] ?? '');

    $emailTo = "amarnathpalanivel23@gmail.com";
    $response = [
        "nameMessage" => "",
        "emailMessage" => "",
        "messageMessage" => "",
        "succesMessage" => ""
    ];

    if ($name === "") {
        $response["nameMessage"] = "x";
    }

    if (!filter_var($clientEmail, FILTER_VALIDATE_EMAIL)) {
        $response["emailMessage"] = "x";
    }

    if ($message === "") {
        $response["messageMessage"] = "x";
    }

    if ($response["nameMessage"] === "" && $response["emailMessage"] === "" && $response["messageMessage"] === "" && $honeypot === "") {

        $emailSubject = "Contact Form | $name | " . $_SERVER["SERVER_NAME"];

        $headers  = "MIME-Version: 1.0
";
        $headers .= "Content-type: text/html; charset=UTF-8
";
        $headers .= "From: $name <$clientEmail>
";
        $headers .= "Reply-To: $clientEmail
";

        $emailBody = "
            <h2>New Contact Form Message</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$clientEmail}</p>
            <p><strong>Message:</strong><br>" . nl2br($message) . "</p>
        ";

        if (mail($emailTo, $emailSubject, $emailBody, $headers)) {
            $response["succesMessage"] = "✔ Thank you! Your message has been sent successfully.";
        } else {
            $response["succesMessage"] = "❌ Error sending message. Please try again later.";
        }
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
