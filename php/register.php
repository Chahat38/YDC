<?php
/**
 * register.php — registration form (events, courses, internships, societies).
 * Runs without a database: submissions are saved to data/*.jsonl and,
 * if enabled in includes/config.php, emailed to the office.
 */
require __DIR__ . '/includes/functions.php';

$form = ydc_form_state('registration');

$page  = 'register';
$title = 'Register | YDC KUST';
$desc  = 'Register for YDC KUST events, courses, internships and the Youth Council.';

require __DIR__ . '/includes/header.php';

$programGroups = array(
    'Events' => array(
        array('National Youth Innovation Summit', 'nyis', 'National Youth Innovation Summit (15 Dec)'),
        array('Career Counseling Workshop', 'career-workshop', 'Career Counseling Workshop (08 Jan)'),
        array('Startup Bootcamp', 'bootcamp', 'Startup Bootcamp (22 Jan)'),
        array('Green Campus Drive', 'green-drive', 'Green Campus Drive (05 Feb)'),
    ),
    'Short courses' => array(
        array('YDC short course', 'course-ydc', 'YDC short course'),
        array('NAVTTC short course', 'course-navttc', 'NAVTTC short course'),
    ),
    'Internships' => array(
        array('Volunteer internship', 'intern-volunteer', 'Volunteer internship'),
        array('Paid internship', 'intern-paid', 'Paid internship'),
    ),
    'Other' => array(
        array('PMYDP society', 'pmydp', 'PMYDP (student society)'),
        array('Youth Council', 'council', 'Youth Council (register interest)'),
        array('Digital Youth Hub membership', 'membership', 'Digital Youth Hub membership'),
    ),
);

$departments = array('Computer Science', 'Information Technology', 'Software Engineering', 'Electrical Engineering', 'Mechanical Engineering', 'Chemical Engineering', 'Mathematics', 'Physics', 'Chemistry', 'Biotechnology', 'Management Sciences', 'Commerce', 'Economics', 'English', 'Other');
$semesters   = array('1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', 'Graduate', 'MS / PhD');
?>
<main id="main"><section class="phead "><div class="wrap"><div class="crumbs"><a href="index.php">Home</a><i>/</i>Register</div><div class="fourbar" aria-hidden="true"><i></i><i></i><i></i><i></i></div><h1>Register</h1><p>One form for events, short courses, internships, the Youth Council and the Digital Youth Hub.</p></div></section>
<section class="sec"><div class="wrap form-wrap">
<div><h2>Tell us who you are</h2><p>Choose what you want to join, fill in your details and submit. We use your information only to manage YDC programs.</p>
<ul class="info-list"><li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg></span><div><b>Takes about two minutes</b>Only the starred fields are required.</div></li><li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18v14H3z M3 7l9 6 9-6"/></svg></span><div><b>Confirmation</b>You will get a reference code, and the office will follow up by email or WhatsApp.</div></li><li><span class="ico"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg></span><div><b>Need help?</b>Call <?= e(ydc_site()['phone']) ?> or visit the office near the Main Gate.</div></li></ul></div>
<div>
<form class="f" data-form="registration" action="register.php" method="post" data-php="1" novalidate<?= $form['sent'] ? ' style="display:none"' : '' ?>>
<input type="hidden" name="_token" value="<?= e(ydc_csrf_token()) ?>">
<div class="fgrid">
<div class="<?= ydc_field_class($form, 'program', 'fld full') ?>"><label for="f-program">I want to register for <em aria-hidden="true">*</em></label><select id="f-program" name="program" required><option value="">Select</option><?php foreach ($programGroups as $groupLabel => $options): ?><optgroup label="<?= e($groupLabel) ?>"><?php foreach ($options as $opt): ?><option value="<?= e($opt[0]) ?>" data-key="<?= e($opt[1]) ?>"<?= ydc_selected($form, 'program', $opt[0]) ?>><?= e($opt[2]) ?></option><?php endforeach; ?></optgroup><?php endforeach; ?></select><span class="err" role="alert"><?= e(ydc_error($form, 'program')) ?></span></div>
<div class="<?= ydc_field_class($form, 'name') ?>"><label for="f-name">Full name <em aria-hidden="true">*</em></label><input id="f-name" name="name" type="text" required placeholder="As on your university card" autocomplete="name" value="<?= e(ydc_old($form, 'name')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'name')) ?></span></div>
<div class="<?= ydc_field_class($form, 'email') ?>"><label for="f-email">Email <em aria-hidden="true">*</em></label><input id="f-email" name="email" type="email" required placeholder="name@example.com" autocomplete="email" value="<?= e(ydc_old($form, 'email')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'email')) ?></span></div>
<div class="<?= ydc_field_class($form, 'phone') ?>"><label for="f-phone">Mobile / WhatsApp <em aria-hidden="true">*</em></label><input id="f-phone" name="phone" type="tel" required placeholder="0300 1234567" autocomplete="tel" value="<?= e(ydc_old($form, 'phone')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'phone')) ?></span></div>
<div class="<?= ydc_field_class($form, 'roll') ?>"><label for="f-roll">KUST roll / registration no. <em aria-hidden="true">*</em></label><input id="f-roll" name="roll" type="text" required placeholder="e.g. 2022-CS-123" autocomplete="off" value="<?= e(ydc_old($form, 'roll')) ?>"><span class="err" role="alert"><?= e(ydc_error($form, 'roll')) ?></span></div>
<div class="<?= ydc_field_class($form, 'department') ?>"><label for="f-department">Department <em aria-hidden="true">*</em></label><select id="f-department" name="department" required><option value="">Select</option><?php foreach ($departments as $d): ?><option<?= ydc_selected($form, 'department', $d) ?>><?= e($d) ?></option><?php endforeach; ?></select><span class="err" role="alert"><?= e(ydc_error($form, 'department')) ?></span></div>
<div class="<?= ydc_field_class($form, 'semester') ?>"><label for="f-semester">Semester <em aria-hidden="true">*</em></label><select id="f-semester" name="semester" required><option value="">Select</option><?php foreach ($semesters as $s): ?><option<?= ydc_selected($form, 'semester', $s) ?>><?= e($s) ?></option><?php endforeach; ?></select><span class="err" role="alert"><?= e(ydc_error($form, 'semester')) ?></span></div>
<div class="fld full"><label for="f-message">Anything we should know? (optional)</label><textarea id="f-message" name="message" placeholder="Skills, experience, special requirements"><?= e(ydc_old($form, 'message')) ?></textarea></div>
<div class="hp"><label>Leave empty<input class="hp-in" name="website" tabindex="-1" autocomplete="off"></label></div>
</div>
<p style="margin:1.4rem 0 0"><button class="btn btn-p" type="submit">Submit registration</button></p>
<p class="fnote">By submitting you agree that YDC KUST may contact you about this registration.</p></form>
<div class="ok<?= $form['sent'] ? ' show' : '' ?>" aria-live="polite"><div class="tick"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12l5 5L20 7"/></svg></div><h2>Thank you, <span class="who"><?= e($form['name']) ?></span>.</h2><p>We have received your details. The YDC office will contact you on the email or number you gave.</p><p>Your reference: <code class="ref"><?= e($form['ref']) ?></code></p><p><a class="btn btn-o" href="index.php">Back to home</a></p></div>
<div class="alert<?= !empty($form['errors']) ? ' show' : '' ?>" role="alert"><?= e(isset($form['errors']['_']) ? $form['errors']['_'] : 'Please check the highlighted fields and try again.') ?></div>
</div>
</div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>
