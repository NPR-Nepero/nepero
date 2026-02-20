<?php
declare(strict_types=1);

const REPORT_TO = "NPR-nepero@proton.me";
const REPORT_FROM = "subscribe@npr-nepero.org";
const SUBSCRIBERS_FILE = __DIR__ . "/newsletter_subscribers.txt";

if (!file_exists(SUBSCRIBERS_FILE)) {
    exit("Missing newsletter_subscribers.txt\n");
}

$content = (string) file_get_contents(SUBSCRIBERS_FILE);
$filename = "newsletter_subscribers_" . date("Y-m-d") . ".txt";
$subject = "Weekly subscribers list";
$body = "Attached: current newsletter subscribers list.";
$boundary = "b_" . md5((string) microtime(true));

$headers = [];
$headers[] = "From: NePeRo Newsletter <" . REPORT_FROM . ">";
$headers[] = "Reply-To: " . REPORT_FROM;
$headers[] = "MIME-Version: 1.0";
$headers[] = "Content-Type: multipart/mixed; boundary=\"" . $boundary . "\"";

$message = "";
$message .= "--" . $boundary . "\r\n";
$message .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
$message .= $body . "\r\n";
$message .= "--" . $boundary . "\r\n";
$message .= "Content-Type: text/plain; name=\"" . $filename . "\"\r\n";
$message .= "Content-Transfer-Encoding: base64\r\n";
$message .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n\r\n";
$message .= chunk_split(base64_encode($content)) . "\r\n";
$message .= "--" . $boundary . "--\r\n";

$ok = @mail(REPORT_TO, $subject, $message, implode("\r\n", $headers));
if (!$ok) {
    exit("Failed to send weekly report email.\n");
}

echo "Weekly report sent.\n";
