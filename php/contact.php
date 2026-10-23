<?php
/**
 * contact.php — contact form.
 * Runs without a database: submissions are saved to data/*.jsonl and,
 * if enabled in includes/config.php, emailed to the office.
 */
require __DIR__ . '/includes/functions.php';

$form = ydc_form_state('contact');
$site = ydc_site();

$page  = 'contact';
$title = 'Contact | YDC KUST';
$desc  = 'Contact YDC KUST.';

require __DIR__ . '/includes/header.php';

$subjects = array('Career counseling', 'Entrepreneurial support', 'Scholarships & financial aid', 'Job hunting & networking', 'Digitalized university services', 'Extracurricular activities', 'Partnership', 'Other');
?>
<main id="main"><section class="phead "><div class="wrap"><div class="crumbs"><a href="index.php">Home</a><i>/</i>Contact</div><div class="fourbar" aria-hidden="true"><i></i><i></i><i></i><i></i></div><h1>Contact Us</h1><p>Questions about programs, events or partnerships? Send us a message or visit the office.</p></div></section>
<section class="sec"><div class="wrap form-wrap">
<div><h2>Visit or call</h2><ul class="info-list">
<li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg></span><div><b>Office</b><?= e($site['address']) ?>, Kohat University of Science &amp; Technology</div></li>
<li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span><div><b>Phone</b><a href="<?= e($site['phone_href']) ?>"><?= e($site['phone']) ?></a></div></li>
<li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18v14H3z M3 7l9 6 9-6"/></svg></span><div><b>Email</b><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></div></li></ul>
<p style="margin-top:2rem">Want to join a program? Use the <a href="register.php">registration form</a> instead.</p></div>
<div>
<form class="f" data-form="contact" action="contact.php" method="post" data-php="1" novalidate<?= $form['sent'] ? ' style="display:none"' : '' ?>>
<input type="hidden" name="_token" value="<?= e(ydc_csrf_token()) ?>">
<div class="fgrid">
<div class="<?= ydc_field_class($form, 'name') ?>"><label for="f-name">Your name <em aria-hidden="true">*</em></label><input id="f-name" name="name" type="text" required placeholder="" autocomplete="name" value="<?= e(ydc_old($form, 'name')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'name')) ?></span></div>
<div class="<?= ydc_field_class($form, 'email') ?>"><label for="f-email">Email <em aria-hidden="true">*</em></label><input id="f-email" name="email" type="email" required placeholder="name@example.com" autocomplete="email" value="<?= e(ydc_old($form, 'email')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'email')) ?></span></div>
<div class="<?= ydc_field_class($form, 'subject', 'fld full') ?>"><label for="f-subject">Topic <em aria-hidden="true">*</em></label><select id="f-subject" name="subject" required><option value="">Select</option><?php foreach ($subjects as $s): ?><option<?= ydc_selected($form, 'subject', $s) ?>><?= e($s) ?></option><?php endforeach; ?></select><span class="err" role="alert"><?= e(ydc_error($form, 'subject')) ?></span></div>
<div class="<?= ydc_field_class($form, 'message', 'fld full') ?>"><label for="f-message">Message <em aria-hidden="true">*</em></label><textarea id="f-message" name="message" required placeholder="How can we help?"><?= e(ydc_old($form, 'message')) ?></textarea><span class="err" role="alert"><?= e(ydc_error($form, 'message')) ?></span></div>
<div class="hp"><label>Leave empty<input class="hp-in" name="website" tabindex="-1" autocomplete="off"></label></div>
</div>
<p style="margin:1.4rem 0 0"><button class="btn btn-p" type="submit">Send message</button></p>
</form>
<div class="ok<?= $form['sent'] ? ' show' : '' ?>" aria-live="polite"><div class="tick"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg></div><h2>Thank you, <span class="who"><?= e($form['name']) ?></span>.</h2><p>We have received your message and will reply by email.</p><p>Your reference: <code class="ref"><?= e($form['ref']) ?></code></p><p><a class="btn btn-o" href="index.php">Back to home</a></p></div>
<div class="alert<?= !empty($form['errors']) ? ' show' : '' ?>" role="alert"><?= e(isset($form['errors']['_']) ? $form['errors']['_'] : 'Please check the highlighted fields and try again.') ?></div>
</div></div></section>
<section class="sec" style="padding-top:0"><div class="wrap"><iframe title="Map of KUST" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3326.1575972008545!2d71.44331677401003!3d33.52328794547822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38d8ec241a467237%3A0xf7409abf0918f110!2sKohat%20University%20of%20Science%20and%20Technology.!5e0!3m2!1sen!2s!4v1738994787849!5m2!1sen!2s" style="width:100%;height:380px;border:0;border-radius:var(--r-l)" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
