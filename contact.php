<?php
/**
 * Contact Form Handler — Wealth & Legacy Financial
 * Receives form submissions and sends an email to deaconbartush@gmail.com
 * 
 * Place this file in the same directory as index.html on your web server.
 * Requires: PHP 7.0+ with mail() function enabled (most shared hosting supports this).
 */

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

// ── Configuration ──
$recipient_email = 'deaconbartush@gmail.com';
$email_subject_prefix = '[W&L Website]';

// ── Only accept POST requests ──
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ── Rate limiting (simple file-based, 5 submissions per IP per hour) ──
$rate_limit_dir = sys_get_temp_dir() . '/wl_contact_limits';
if (!is_dir($rate_limit_dir)) {
    @mkdir($rate_limit_dir, 0755, true);
}
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_file = $rate_limit_dir . '/' . md5($ip) . '.txt';
$now = time();
$submissions = [];

if (file_exists($rate_file)) {
    $raw = file_get_contents($rate_file);
    $submissions = array_filter(explode("\n", trim($raw)), function($ts) use ($now) {
        return ($now - intval($ts)) < 3600; // Keep entries from last hour
    });
}

if (count($submissions) >= 5) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many submissions. Please try again later or email us directly.']);
    exit;
}

// ── Sanitize and validate inputs ──
function clean($str) {
    return htmlspecialchars(strip_tags(trim($str)), ENT_QUOTES, 'UTF-8');
}

$first_name  = clean($_POST['first_name'] ?? '');
$last_name   = clean($_POST['last_name'] ?? '');
$email       = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone       = clean($_POST['phone'] ?? '');
$state       = clean($_POST['state'] ?? 'Not provided');
$experience  = clean($_POST['experience'] ?? 'Not provided');
$message     = clean($_POST['message'] ?? 'No additional message');

// ── Validate required fields ──
$errors = [];
if (empty($first_name)) $errors[] = 'First name is required.';
if (empty($last_name))  $errors[] = 'Last name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
if (empty($phone))      $errors[] = 'Phone number is required.';

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Honeypot check (hidden field — bots fill it, humans don't) ──
if (!empty($_POST['website_url'])) {
    // Silently reject — likely a bot
    echo json_encode(['success' => true, 'message' => 'Application received.']);
    exit;
}

// ── Build the email ──
$full_name = "$first_name $last_name";
$subject = "$email_subject_prefix New Application from $full_name";

$experience_labels = [
    'none'        => 'No experience — starting fresh',
    'some'        => 'Some experience (less than 1 year)',
    'experienced' => 'Experienced (1+ years)',
    'licensed'    => 'Already licensed',
];
$experience_display = $experience_labels[$experience] ?? $experience;

$email_body = <<<EOT
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  NEW APPLICATION — W&L FINANCIAL
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

Name:        $full_name
Email:       $email
Phone:       $phone
State:       $state
Experience:  $experience_display

Message:
$message

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Submitted: {$_SERVER['REQUEST_TIME']}
IP: $ip
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
EOT;

// ── Email headers ──
$headers = [
    'From: W&L Financial Website <noreply@' . ($_SERVER['HTTP_HOST'] ?? 'wealthandlegacyfinancial.com') . '>',
    'Reply-To: ' . $full_name . ' <' . $email . '>',
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8',
    'MIME-Version: 1.0',
];

// ── Send the email ──
$sent = mail($recipient_email, $subject, $email_body, implode("\r\n", $headers));

if ($sent) {
    // Record this submission for rate limiting
    $submissions[] = $now;
    file_put_contents($rate_file, implode("\n", $submissions));

    // Optional: log submission to CSV for backup
    $log_file = __DIR__ . '/contact_submissions.csv';
    $is_new = !file_exists($log_file);
    $fp = fopen($log_file, 'a');
    if ($fp) {
        if ($is_new) {
            fputcsv($fp, ['Date', 'Name', 'Email', 'Phone', 'State', 'Experience', 'Message']);
        }
        fputcsv($fp, [date('Y-m-d H:i:s'), $full_name, $email, $phone, $state, $experience_display, $message]);
        fclose($fp);
    }

    echo json_encode(['success' => true, 'message' => 'Application received! We\'ll be in touch within 24 hours.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'We couldn\'t send your message right now. Please email us directly at deaconbartush@gmail.com']);
}
