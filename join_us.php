<?php
declare(strict_types=1);

$scriptDir = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
$basePath = $scriptDir === "" ? "" : $scriptDir;
$newsletterHandler = $basePath . "/newsletter.php";
$homeUrl = $basePath . "/";
$manifestoUrl = $basePath . "/manifesto.html";
$createJournalUrl = $basePath . "/create_a_journal.html";
$connectionsUrl = $basePath . "/connections.html";
$resourcesUrl = $basePath . "/resources.html";
$postsUrl = $basePath . "/posts.html";
$joinUrl = $basePath . "/join_us.html";
$logoUrl = $basePath . "/assets/images/logo.webp";
$cssUrl = $basePath . "/assets/css/style.css";

$status = $_GET["status"] ?? "";
$message = "";

if ($status === "mail_sent") {
    $message = "Check your email and click the confirmation link to complete the request. If you do not see it, check your spam folder.";
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
  <title>Join Us - NePeRo</title>
  <link rel="icon" type="image/webp" href="<?php echo htmlspecialchars($logoUrl, ENT_QUOTES, "UTF-8"); ?>">
  <link rel="stylesheet" href="<?php echo htmlspecialchars($cssUrl, ENT_QUOTES, "UTF-8"); ?>">
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <a href="<?php echo htmlspecialchars($homeUrl, ENT_QUOTES, "UTF-8"); ?>" class="site-logo">
        <img src="<?php echo htmlspecialchars($logoUrl, ENT_QUOTES, "UTF-8"); ?>" alt="NePeRo logo">
      </a>
      <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
      <nav class="site-nav">
        <a href="<?php echo htmlspecialchars($homeUrl, ENT_QUOTES, "UTF-8"); ?>">Home</a>
        <a href="<?php echo htmlspecialchars($manifestoUrl, ENT_QUOTES, "UTF-8"); ?>">Manifesto</a>
        <a href="<?php echo htmlspecialchars($createJournalUrl, ENT_QUOTES, "UTF-8"); ?>">Create a Journal</a>
        <a href="<?php echo htmlspecialchars($connectionsUrl, ENT_QUOTES, "UTF-8"); ?>">Connections</a>
        <a href="<?php echo htmlspecialchars($resourcesUrl, ENT_QUOTES, "UTF-8"); ?>">Resources</a>
        <a href="<?php echo htmlspecialchars($postsUrl, ENT_QUOTES, "UTF-8"); ?>">Posts</a>
        <a href="<?php echo htmlspecialchars($joinUrl, ENT_QUOTES, "UTF-8"); ?>">Join Us</a>
      </nav>
    </div>
  </header>

  <main>
    <h1>Join Us</h1>
    <p>Subscribe to the NePeRo newsletter to receive the latest summary of each meeting and updates on all activities carried out by NePeRo.</p>
    <p><small>A confirmation link will be sent by email. If you do not find it, check your spam folder.</small></p>

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

  </main>

  <footer>
    <p>
      <a href="http://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a> NePeRo.
      Website built with <a href="https://jekyllrb.com/">Jekyll</a>
    </p>
  </footer>

  <script>
    const header = document.querySelector('.site-header');
    const nav = document.querySelector('.site-nav');
    const toggle = document.querySelector('.nav-toggle');

    function updateNavMode() {
      header.classList.remove('is-collapsed');
      nav.classList.remove('open');
      const links = Array.from(nav.children);
      if (links.length === 0) return;
      const firstTop = links[0].offsetTop;
      const wrapped = links.some(link => link.offsetTop > firstTop);
      header.classList.toggle('is-collapsed', wrapped);
    }

    toggle.addEventListener('click', () => {
      nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', nav.classList.contains('open'));
    });

    window.addEventListener('resize', updateNavMode);
    window.addEventListener('load', updateNavMode);
  </script>
</body>
</html>
