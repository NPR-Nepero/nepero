<?php
declare(strict_types=1);

$scriptDir = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
$basePath = $scriptDir === "" ? "" : $scriptDir;
$newsletterHandler = $basePath . "/newsletter.php";

$status = $_GET["status"] ?? "";
$message = "";

if ($status === "mail_sent") {
    $message = "Check your email and click the confirmation link to complete the request.";
} elseif ($status === "invalid_email") {
    $message = "Please provide a valid email address.";
} elseif ($status === "mail_error") {
    $message = "Could not send the email from this server.";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Join us - NePeRo</title>
  <link rel="icon" type="image/webp" href="assets/images/logo.webp">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <main style="max-width: 720px; margin: 2rem auto; padding: 0 1rem;">
    <h1>Join us</h1>
    <p>Subscribe to the NePeRo newsletter. Confirmation happens through an email link.</p>

    <?php if ($message !== ""): ?>
      <p><strong><?php echo htmlspecialchars($message, ENT_QUOTES, "UTF-8"); ?></strong></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($newsletterHandler, ENT_QUOTES, "UTF-8"); ?>">
      <input type="hidden" name="action" value="subscribe">
      <label for="newsletter-email-subscribe">Email address</label><br>
      <input id="newsletter-email-subscribe" name="email" type="email" required placeholder="you@example.com">
      <button type="submit">Subscribe</button>
    </form>

    <p><small>Need to leave? Use the unsubscribe form below.</small></p>

    <form method="post" action="<?php echo htmlspecialchars($newsletterHandler, ENT_QUOTES, "UTF-8"); ?>">
      <input type="hidden" name="action" value="unsubscribe">
      <label for="newsletter-email-unsubscribe">Email address</label><br>
      <input id="newsletter-email-unsubscribe" name="email" type="email" required placeholder="you@example.com">
      <button type="submit">Unsubscribe</button>
    </form>

    <p><small>The list is stored in <code>newsletter_subscribers.txt</code> on this server.</small></p>
  </main>
</body>
</html>
