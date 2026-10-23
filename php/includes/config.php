<?php
/**
 * ============================================================
 *  YDC KUST — site configuration
 * ============================================================
 *  This site runs WITHOUT a database. Nothing here connects to
 *  MySQL, so existing databases/tables on the hosting account
 *  are never touched.
 *
 *  Change text values below. No other file needs editing.
 * ============================================================
 */

return [

    /* ---------- basic site details ---------- */
    'site' => [
        'name'        => 'YDC KUST',
        'tagline'     => 'Kohat University of Science & Technology',
        'email'       => 'ydc@kust.edu.pk',
        'phone'       => '0922 529100 Ext: 4622',
        'phone_href'  => 'tel:+92922529100',
        'address'     => 'Near Main Gate, KUST, Kohat',
        'description' => 'Prime Minister’s Youth Development Center at Kohat University of Science and Technology.',
        'year'        => '2026',
    ],

    /* ---------- forms (registration + contact) ---------- */
    'forms' => [

        /* Save each submission as one line in data/submissions-YYYY-MM.jsonl
           Set to false to disable file storage. */
        'store' => true,

        /* Send an email copy with the built-in PHP mail() function.
           Many shared hosts block mail() or mark it as spam, so this is
           OFF by default. Turn it on only after testing. */
        'mail'  => false,

        /* Where notification emails go (only used when 'mail' is true). */
        'to'    => 'ydc@kust.edu.pk',

        /* From address for notification emails. Leave empty to auto-build
           from the current hostname (recommended). */
        'from'  => '',
    ],

    /* ---------- upload limits ---------- */
    'uploads' => [
        /* Max submissions accepted from one session in 10 minutes. */
        'per_session' => 6,
    ],

    /* ============================================================
       DATABASE — intentionally not used yet.
       ------------------------------------------------------------
       The site is fully functional without MySQL. When database
       access becomes available, add the credentials here and create
       a separate includes/db.php. Do NOT run schema changes that
       could alter existing tables on the hosting account.

       'db' => [
           'host' => 'localhost',
           'name' => '',
           'user' => '',
           'pass' => '',
       ],
       ============================================================ */
];
