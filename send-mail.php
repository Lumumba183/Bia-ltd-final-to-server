<?php
/*
 * BIA Limited — Contact form handler (cPanel / Apache / PHP)
 * Receives the contact form POST, validates and sanitizes input,
 * sends the enquiry by email, then redirects to the success page.
 */

// ---- Configuration ---------------------------------------------------------
$to      = 'info@bia.co.ke';            // mailbox that receives enquiries
$subject = 'New Website Inquiry — bia.co.ke';
$from    = 'no-reply@bia.co.ke';               // must be a domain on this hosting account
// ----------------------------------------------------------------------------

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.html');
    exit;
}

// Honeypot: silently drop bots
if (!empty($_POST['bot-field'])) {
    header('Location: /success.html');
    exit;
}

// Collect + sanitize
$name         = trim(strip_tags($_POST['name'] ?? ''));
$email        = trim($_POST['email'] ?? '');
$organisation = trim(strip_tags($_POST['organisation'] ?? ''));
$sector       = trim(strip_tags($_POST['sector'] ?? ''));
$message      = trim(strip_tags($_POST['message'] ?? ''));

// Validate required fields
if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /contact.html?error=1');
    exit;
}

// Block header injection
if (preg_match("/[\r\n]/", $name) || preg_match("/[\r\n]/", $email)) {
    header('Location: /contact.html?error=1');
    exit;
}

// Build the email body
$body  = "A new inquiry has been submitted through bia.co.ke\n";
$body .= "------------------------------------------------------------\n\n";
$body .= "Name:         {$name}\n";
$body .= "Email:        {$email}\n";
$body .= "Organisation: " . ($organisation !== '' ? $organisation : '—') . "\n";
$body .= "Sector:       " . ($sector !== '' ? $sector : '—') . "\n\n";
$body .= "Project Details:\n{$message}\n\n";
$body .= "------------------------------------------------------------\n";
$body .= 'Submitted: ' . date('d M Y, H:i') . " EAT\n";
$body .= 'IP: ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";

// Headers
$headers   = [];
$headers[] = "From: BIA Website <{$from}>";
$headers[] = "Reply-To: {$name} <{$email}>";
$headers[] = 'Content-Type: text/plain; charset=UTF-8';
$headers[] = 'X-Mailer: PHP/' . phpversion();

$sent = mail($to, $subject, $body, implode("\r\n", $headers));

if ($sent) {
    header('Location: /success.html');
} else {
    header('Location: /contact.html?error=1');
}
exit;
