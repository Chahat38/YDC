<?php
/**
 * Shared <head> + site header + navigation.
 *
 * Expects these variables (all optional):
 *   $page  — slug of the current page, e.g. 'team'   (for active nav)
 *   $title — full <title> text
 *   $desc  — meta description
 */
$site = ydc_site();

$page  = isset($page) ? $page : '';
$title = isset($title) && $title !== '' ? $title : $site['name'];
$desc  = isset($desc) && $desc !== '' ? $desc : $site['description'];

$active = function (array $slugs) use ($page) {
    return in_array($page, $slugs, true) ? ' on' : '';
};

$chevron = '<svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?></title><meta name="description" content="<?= e($desc) ?>">
<meta name="theme-color" content="#00A86B"><link rel="icon" href="assets/img/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css"><link rel="stylesheet" href="assets/css/pro.css"><link rel="stylesheet" href="assets/css/redesign.css"></head><body>
<a class="skip" href="#main">Skip to content</a>
<header class="site"><div class="wrap">
<a class="brand" href="index.php"><img src="assets/img/logo.png" alt="" width="50" height="50"><span><b><?= e($site['name']) ?></b><small><?= e($site['tagline']) ?></small></span></a>
<button class="burger" aria-label="Open menu" aria-expanded="false"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16 M4 12h16 M4 18h16"/></svg></button>
<nav class="main" aria-label="Main"><button class="nav-close" aria-label="Close menu"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12 M18 6L6 18"/></svg></button><ul>
<li><a class="top<?= $active(array('index')) ?>" href="index.php">Home</a></li>

<li class="has-drop"><button class="top<?= $active(array('about', 'vision-mission', 'objectives', 'team', 'mous')) ?>" aria-expanded="false" aria-haspopup="true">About YDC<?= $chevron ?></button><div class="drop">
<a href="about.php"<?= $active(array('about')) ? ' class="on"' : '' ?>>About YDC<small>Who we are and what we do</small></a>
<a href="vision-mission.php"<?= $active(array('vision-mission')) ? ' class="on"' : '' ?>>Vision &amp; Mission</a>
<a href="objectives.php"<?= $active(array('objectives')) ? ' class="on"' : '' ?>>Objectives</a>
<a href="team.php"<?= $active(array('team')) ? ' class="on"' : '' ?>>Our Team</a>
<a href="mous.php"<?= $active(array('mous')) ? ' class="on"' : '' ?>>MOUs &amp; Partners</a>
</div></li>

<li class="has-drop"><button class="top<?= $active(array('education', 'employment', 'engagement', 'environment')) ?>" aria-expanded="false" aria-haspopup="true">4 E's<?= $chevron ?></button><div class="drop">
<a href="education.php"<?= $active(array('education')) ? ' class="on"' : '' ?>><span class="dot" style="background:var(--edu)"></span>Education<small>Scholarships, workshops, mentorship</small></a>
<a href="employment.php"<?= $active(array('employment')) ? ' class="on"' : '' ?>><span class="dot" style="background:var(--emp)"></span>Employment<small>Careers, jobs, internships</small></a>
<a href="engagement.php"<?= $active(array('engagement')) ? ' class="on"' : '' ?>><span class="dot" style="background:var(--eng)"></span>Engagement<small>Societies, events, leadership</small></a>
<a href="environment.php"<?= $active(array('environment')) ? ' class="on"' : '' ?>><span class="dot" style="background:var(--env)"></span>Environment<small>Green campus and awareness</small></a>
</div></li>

<li class="has-drop"><button class="top<?= $active(array('short-courses', 'internships', 'digital-youth-hub', 'pmydp', 'youth-council')) ?>" aria-expanded="false" aria-haspopup="true">Programs<?= $chevron ?></button><div class="drop">
<a href="short-courses.php"<?= $active(array('short-courses')) ? ' class="on"' : '' ?>>Short Courses<small>YDC and NAVTTC courses</small></a>
<a href="internships.php"<?= $active(array('internships')) ? ' class="on"' : '' ?>>Internships<small>Volunteer and paid</small></a>
<a href="digital-youth-hub.php"<?= $active(array('digital-youth-hub')) ? ' class="on"' : '' ?>>Digital Youth Hub<small>Online resources and portal</small></a>
<a href="pmydp.php"<?= $active(array('pmydp')) ? ' class="on"' : '' ?>>PMYDP<small>Prime Minister's Youth Development Programme society</small></a>
<a href="youth-council.php"<?= $active(array('youth-council')) ? ' class="on"' : '' ?>>Youth Council<small>Student leadership body</small></a>
</div></li>

<li class="has-drop"><button class="top<?= $active(array('upcoming-events', 'past-events')) ?>" aria-expanded="false" aria-haspopup="true">Events<?= $chevron ?></button><div class="drop">
<a href="upcoming-events.php"<?= $active(array('upcoming-events')) ? ' class="on"' : '' ?>>Upcoming Events</a>
<a href="past-events.php"<?= $active(array('past-events')) ? ' class="on"' : '' ?>>Past Events</a>
</div></li>

<li><a class="top<?= $active(array('opportunities')) ?>" href="opportunities.php">Opportunities</a></li>
<li><a class="top<?= $active(array('magazines')) ?>" href="magazines.php">E-Magazine</a></li>
<li><a class="top<?= $active(array('contact')) ?>" href="contact.php">Contact</a></li>
<li class="nav-cta"><a class="btn btn-p btn-s" href="register.php">Register Now</a></li>
</ul></nav>
</div></header><div class="scrim"></div>
