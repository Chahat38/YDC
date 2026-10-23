<?php
/**
 * opportunities.php  —  generated PHP page for the YDC KUST site.
 * Header and footer live in includes/ so they only need editing once.
 */
require __DIR__ . '/includes/functions.php';

$page  = 'opportunities';
$title = 'Opportunities | YDC KUST';
$desc  = 'Scholarships, conferences, fellowships and competitions from organisations outside KUST, collected by YDC.';

require __DIR__ . '/includes/header.php';
?>
<main id="main"><section class="phead"><div class="wrap"><div class="crumbs"><a href="index.php">Home</a><i>/</i>Opportunities</div><div class="fourbar" aria-hidden="true"><i></i><i></i><i></i><i></i></div><h1>Opportunities Beyond KUST</h1><p>Scholarships, conferences, fellowships and competitions run by other universities and organisations. YDC collects them here so you do not have to hunt.</p></div></section>
<section class="sec"><div class="wrap"><div class="opp-note"><b>Check before you apply.</b> These are external programs. Dates and eligibility change every year, so always confirm on the official website.</div>
<div class="opp-filters" role="group" aria-label="Filter opportunities"></div><div class="opp-grid" id="opp-grid"></div>
<noscript><p>Please enable JavaScript to see the list of opportunities.</p></noscript>
<div class="opp-cta"><h3>Found something students should know about?</h3><p>Send us the link and we will add it to this page.</p><a class="btn btn-p" href="contact.php">Send a suggestion</a></div></div></section></main>
<?php require __DIR__ . '/includes/footer.php'; ?>