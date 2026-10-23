<?php
/**
 * Shared site footer + lightbox + scripts.
 */
$site = ydc_site();
?>
<footer class="site"><div class="wrap">
<div class="cols">
<div><a class="brand" href="index.php"><img src="assets/img/logo.png" alt="" width="50" height="50"><span><b><?= e($site['name']) ?></b></span></a>
<p>Prime Minister’s Youth Development Center at KUST. We help students grow through Education, Employment, Engagement and Environment.</p>
<div class="social"><a href="#" aria-label="Facebook"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a><a href="#" aria-label="Instagram"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M17 2H7a5 5 0 0 0-5 5v10a5 5 0 0 0 5 5h10a5 5 0 0 0 5-5V7a5 5 0 0 0-5-5z M16 11.4a4 4 0 1 1-3.4-3.4 4 4 0 0 1 3.4 3.4z M17.5 6.5h.01"/></svg></a><a href="#" aria-label="LinkedIn"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z M2 9h4v12H2z M4 6a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/></svg></a></div></div>
<div><h4>Explore</h4><ul><li><a href="about.php">About YDC</a></li><li><a href="team.php">Our team</a></li><li><a href="upcoming-events.php">Upcoming events</a></li><li><a href="magazines.php">E-Magazine</a></li><li><a href="mous.php">MOUs &amp; partners</a></li></ul></div>
<div><h4>Programs</h4><ul><li><a href="short-courses.php">Short courses</a></li><li><a href="internships.php">Internships</a></li><li><a href="opportunities.php">Opportunities</a></li><li><a href="digital-youth-hub.php">Digital Youth Hub</a></li><li><a href="youth-council.php">Youth Council</a></li><li><a href="pmydp.php">PMYDP</a></li><li><a href="register.php">Register</a></li></ul></div>
<div><h4>Get in touch</h4><ul><li><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg><span><?= e($site['address']) ?></span></li><li><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/></svg><a href="<?= e($site['phone_href']) ?>"><?= e($site['phone']) ?></a></li><li><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5h18v14H3z M3 7l9 6 9-6"/></svg><a href="mailto:<?= e($site['email']) ?>"><?= e($site['email']) ?></a></li></ul></div>
</div>
<div class="legal"><span><span class="cc" role="img" aria-label="Copyright">CH</span><?= e($site['year']) ?> <?= e($site['name']) ?>. All rights reserved.</span><div class="fourbar" aria-hidden="true"><i></i><i></i><i></i><i></i></div></div>
</div></footer>
<div class="lb" role="dialog" aria-label="Photo viewer"><button class="x" aria-label="Close"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12 M18 6L6 18"/></svg></button><button class="pv" aria-label="Previous"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14 M13 6l6 6-6 6"/></svg></button><img alt=""><button class="nx" aria-label="Next"><svg class="i " viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14 M13 6l6 6-6 6"/></svg></button></div>
<script src="assets/js/config.js"></script><script src="assets/js/main.js"></script>
</body></html>
