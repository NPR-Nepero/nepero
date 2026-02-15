---
layout: default
title: Join us
---

## Join us

Subscribe to the NePeRo newsletter to receive the latest summary of each meeting and updates on all activities carried out by NePeRo.

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

<p><small>Requests are sent by email and then recorded in <code>newsletter_subscribers.txt</code>.</small></p>

<script>
function handleNewsletter(event, action) {
  event.preventDefault();
  var form = event.target;
  var email = form.querySelector('input[name="email"]').value.trim();
  if (!email) return false;
  var subject = action === 'subscribe'
    ? 'Inscription newsletter NePeRo'
    : 'Inscription newsletter NePeRo - Unsubscription';
  var body = 'Action: ' + action + '\nEmail: ' + email;
  window.location.href = 'mailto:NPR-nepero@proton.me?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
  return false;
}
</script>
