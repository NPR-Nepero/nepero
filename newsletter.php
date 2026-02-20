<?php
declare(strict_types=1);

const SUBSCRIBERS_FILE = __DIR__ . "/newsletter_subscribers.txt";
const CONTACT_EMAIL = "subscribe@npr-nepero.org";

function base_url(): string
{
    $https = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off");
    $scheme = $https ? "https" : "http";
    $host = $_SERVER["HTTP_HOST"] ?? "localhost";
    $scriptDir = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
    $scriptDir = $scriptDir === "" ? "" : $scriptDir;
    return $scheme . "://" . $host . $scriptDir;
}

function app_secret(): string
{
    $env = getenv("NEWSLETTER_SECRET");
    if ($env !== false && trim($env) !== "") {
        return trim($env);
    }
    return "CHANGE_THIS_SECRET_VALUE";
}

function normalize_email(string $email): string
{
    return strtolower(trim($email));
}

function valid_action(string $action): bool
{
    return $action === "subscribe" || $action === "unsubscribe";
}

function token_for(string $action, string $email): string
{
    return hash_hmac("sha256", $action . "|" . $email, app_secret());
}

function render_message(string $title, string $message): void
{
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, "UTF-8");
    $safeTitle = htmlspecialchars($title, ENT_QUOTES, "UTF-8");
    $joinUrl = htmlspecialchars(base_url() . "/join_us.php", ENT_QUOTES, "UTF-8");
    echo "<!doctype html><html lang=\"en\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"><title>{$safeTitle}</title></head><body>";
    echo "<main style=\"max-width: 640px; margin: 3rem auto; padding: 0 1rem; text-align: center; font-family: sans-serif;\">";
    echo "<p>{$safeMessage}</p>";
    echo "<p><a href=\"{$joinUrl}\" style=\"display: inline-block; padding: 0.55rem 0.9rem; border: 1px solid #111; text-decoration: none; color: #111;\">Return to Join Us</a></p>";
    echo "</main>";
    echo "</body></html>";
}

function ensure_subscribers_file(string &$error): bool
{
    $path = SUBSCRIBERS_FILE;

    if (!file_exists($path)) {
        $created = @file_put_contents($path, "");
        if ($created === false) {
            $error = "Cannot create subscribers file.";
            return false;
        }
    }

    if (!is_writable($path)) {
        @chmod($path, 0666);
    }

    if (!is_writable($path)) {
        $error = "Subscribers file is not writable.";
        return false;
    }

    return true;
}

function update_subscribers(string $action, string $email, string &$error): bool
{
    if (!ensure_subscribers_file($error)) {
        return false;
    }

    $existing = @file_get_contents(SUBSCRIBERS_FILE);
    if ($existing === false) {
        $error = "Cannot read subscribers file.";
        return false;
    }

    $lines = preg_split("/\r\n|\n|\r/", $existing);
    if ($lines === false) {
        $lines = [];
    }

    $set = [];
    foreach ($lines as $line) {
        $line = normalize_email($line);
        if ($line !== "" && filter_var($line, FILTER_VALIDATE_EMAIL)) {
            $set[$line] = true;
        }
    }

    if ($action === "subscribe") {
        $set[$email] = true;
    } else {
        unset($set[$email]);
    }

    $emails = array_keys($set);
    sort($emails, SORT_STRING);
    $newContent = implode("\n", $emails);
    if ($newContent !== "") {
        $newContent .= "\n";
    }

    $ok = @file_put_contents(SUBSCRIBERS_FILE, $newContent, LOCK_EX);
    if ($ok === false) {
        $ok = @file_put_contents(SUBSCRIBERS_FILE, $newContent);
    }
    if ($ok === false) {
        $error = "Cannot write subscribers file.";
        return false;
    }
    return true;
}

$mode = $_GET["mode"] ?? "";
if ($mode === "health") {
    header("Content-Type: text/plain; charset=utf-8");
    echo "ok";
    exit;
}

if (isset($_GET["confirm"]) && $_GET["confirm"] === "1") {
    $action = $_GET["action"] ?? "";
    $email = normalize_email((string)($_GET["email"] ?? ""));
    $token = (string)($_GET["token"] ?? "");

    if (!valid_action($action) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        render_message("Invalid request", "The confirmation link is invalid.");
        exit;
    }

    $expected = token_for($action, $email);
    if (!hash_equals($expected, $token)) {
        render_message("Invalid token", "The confirmation token does not match.");
        exit;
    }

    $writeError = "";
    if (!update_subscribers($action, $email, $writeError)) {
        render_message("Write error", "Could not update newsletter_subscribers.txt. " . $writeError);
        exit;
    }

    $verb = $action === "subscribe" ? "subscribed to" : "removed from";
    render_message("Success", $email . " has been " . $verb . " the newsletter.");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    render_message("Method not allowed", "Use the Join us page to send a request.");
    exit;
}

$action = $_POST["action"] ?? "";
$email = normalize_email((string)($_POST["email"] ?? ""));

if (!valid_action($action) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: " . base_url() . "/join_us.php?status=invalid_email");
    exit;
}

$token = token_for($action, $email);
$confirmUrl = base_url() . "/newsletter.php?confirm=1&action=" . rawurlencode($action) . "&email=" . rawurlencode($email) . "&token=" . rawurlencode($token);
$actionLabel = $action === "subscribe" ? "subscribe to" : "unsubscribe from";

$subject = "Confirm newsletter request";
$body = "Click this link to " . $actionLabel . " the NePeRo newsletter:\n\n" . $confirmUrl . "\n";
$headers = "From: NePeRo Newsletter <" . CONTACT_EMAIL . ">\r\n";
$headers .= "Reply-To: " . CONTACT_EMAIL . "\r\n";

$sent = @mail($email, $subject, $body, $headers);
if (!$sent) {
    header("Location: " . base_url() . "/join_us.php?status=mail_error");
    exit;
}

header("Location: " . base_url() . "/join_us.php?status=mail_sent");
exit;
