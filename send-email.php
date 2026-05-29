<?php
/**
 * Yongrui Gym Cable Inquiry Handler
 * Directly sends emails to info@yrsteelwirerope.com
 */

header('Content-Type: application/json');

// 1. Get raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
    exit;
}

// 2. Configuration
$to = "info@yrsteelwirerope.com";
$from_email = "no-reply@yrgymcable.com"; // Recommended to use a domain-based address
$subject = "Inquiry: " . ($data['subject'] ?? "Custom Gym Cable Request");

// 3. Build Body
$message = "You have received a new custom gym cable inquiry from yrgymcable.com\n\n";
$message .= "--- CABLE CONFIGURATION ---\n";
$message .= "Left End:      " . ($data['left'] ?? "N/A") . "\n";
$message .= "Right End:     " . ($data['right'] ?? "N/A") . "\n";
$message .= "Coating:       " . ($data['coating'] ?? "N/A") . "\n";
$message .= "Core Grade:    " . ($data['core'] ?? "N/A") . "\n";
$message .= "Construction:  " . ($data['construction'] ?? "N/A") . "\n";
$message .= "Diameter (OD): " . ($data['diameter'] ?? "N/A") . "\n";
$message .= "Color:         " . ($data['color'] ?? "N/A") . "\n";
$message .= "Length:        " . ($data['length'] ?? "N/A") . " mm\n";
$message .= "Quantity:      " . ($data['quantity'] ?? "N/A") . " pcs\n";
if (!empty($data['notes'])) {
    $message .= "Notes:         " . $data['notes'] . "\n";
}

$message .= "\n--- CONTACT DETAILS ---\n";
$message .= "Name:    " . ($data['name'] ?? "N/A") . "\n";
$message .= "Company: " . ($data['company'] ?? "N/A") . "\n";
$message .= "Email:   " . ($data['email'] ?? "N/A") . "\n";
$message .= "Country: " . ($data['country'] ?? "N/A") . "\n";

// 4. Headers
$headers = "From: Yongrui Website <$from_email>\r\n";
$headers .= "Reply-To: " . ($data['email'] ?? $from_email) . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// 5. Send
if (mail($to, $subject, $message, $headers)) {
    echo json_encode(['status' => 'success', 'message' => 'Inquiry sent successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Server failed to send email.']);
}
?>
