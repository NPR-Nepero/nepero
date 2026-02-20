---
layout: default
title: Join Us
permalink: /join_us_fallback.html
---

# Join Us

Subscribe to the NePeRo newsletter to receive the latest summary of each meeting and updates on all activities carried out by NePeRo.

<p><small>PHP module not available on this server. Your request will open your email client.</small></p>

<form id="newsletter-subscribe-form" onsubmit="return handleNewsletter(event, 'subscribe')">
  <label for="newsletter-email">Email address</label><br>
  <input id="newsletter-email" name="email" type="email" required placeholder="you@example.com">
  <button type="submit">Subscribe</button>
</form>

<p><small>Need to leave? Use the unsubscribe form below.</small></p>

<form id="newsletter-unsubscribe-form" onsubmit="return handleNewsletter(event, 'unsubscribe')">
  <small>
    <label for="newsletter-email-unsubscribe">Email address</label><br>
    <input id="newsletter-email-unsubscribe" name="email" type="email" required placeholder="you@example.com">
    <button type="submit">Unsubscribe</button>
  </small>
</form>

<p><small>If PHP activation is restored, a confirmation link will be sent by email. Please check spam if needed.</small></p>

<script>
function handleNewsletter(event, action) {
  event.preventDefault();
  var form = event.target;
  var email = form.querySelector('input[name="email"]').value.trim();
  if (!email) return false;
  var subject = action === 'subscribe'
    ? 'NePeRo newsletter request: subscribe'
    : 'NePeRo newsletter request: unsubscribe';
  var body = 'Action: ' + action + '\nEmail: ' + email;
  alert('PHP is not available. Your email client will open to send the request.');
  window.location.href = 'mailto:subscribe@npr-nepero.org?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
  return false;
}
</script>
