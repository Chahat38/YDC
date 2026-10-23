<?php
/**
 * ============================================================
 *  YDC KUST — shared helpers
 * ============================================================
 *  Pure PHP. No database, no external libraries.
 *  Works on PHP 7.4 and newer (including PHP 8.x).
 * ============================================================
 */

if (!defined('YDC_ROOT')) {
    define('YDC_ROOT', dirname(__DIR__));
}

/* ------------------------------------------------------------
   Config
   ------------------------------------------------------------ */
function ydc_config()
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/config.php';
    }
    return $config;
}

function ydc_site()
{
    $c = ydc_config();
    return isset($c['site']) ? $c['site'] : array();
}

function ydc_forms()
{
    $c = ydc_config();
    return isset($c['forms']) ? $c['forms'] : array();
}

/* ------------------------------------------------------------
   Output escaping
   ------------------------------------------------------------ */
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ------------------------------------------------------------
   Session (only starts when a form is used)
   ------------------------------------------------------------ */
function ydc_session()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);

    if (PHP_VERSION_ID >= 70300) {
        session_set_cookie_params(array(
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,
            'secure'   => $secure,
            'samesite' => 'Lax',
        ));
    } else {
        session_set_cookie_params(0, '/', '', $secure, true);
    }

    @session_start();
}

/* ------------------------------------------------------------
   CSRF
   ------------------------------------------------------------ */
function ydc_csrf_token()
{
    ydc_session();
    if (empty($_SESSION['ydc_csrf'])) {
        if (function_exists('random_bytes')) {
            $_SESSION['ydc_csrf'] = bin2hex(random_bytes(16));
        } else {
            $_SESSION['ydc_csrf'] = sha1(uniqid('', true) . mt_rand());
        }
    }
    return $_SESSION['ydc_csrf'];
}

function ydc_csrf_ok()
{
    ydc_session();
    $sent = isset($_POST['_token']) ? (string) $_POST['_token'] : '';
    $real = isset($_SESSION['ydc_csrf']) ? (string) $_SESSION['ydc_csrf'] : '';
    return $sent !== '' && $real !== '' && hash_equals($real, $sent);
}

/* ------------------------------------------------------------
   Form field definitions
   ------------------------------------------------------------ */
function ydc_form_rules($type)
{
    if ($type === 'registration') {
        return array(
            'program'    => array('label' => 'Program', 'required' => true),
            'name'       => array('label' => 'Full name', 'required' => true, 'max' => 120),
            'email'      => array('label' => 'Email', 'required' => true, 'email' => true),
            'phone'      => array('label' => 'Mobile / WhatsApp', 'required' => true, 'phone' => true),
            'roll'       => array('label' => 'KUST roll number', 'required' => true, 'max' => 40),
            'department' => array('label' => 'Department', 'required' => true),
            'semester'   => array('label' => 'Semester', 'required' => true),
            'message'    => array('label' => 'Message', 'max' => 2000),
        );
    }

    return array(
        'name'    => array('label' => 'Your name', 'required' => true, 'max' => 120),
        'email'   => array('label' => 'Email', 'required' => true, 'email' => true),
        'subject' => array('label' => 'Topic', 'required' => true),
        'message' => array('label' => 'Message', 'required' => true, 'max' => 3000),
    );
}

/* ------------------------------------------------------------
   Form handling
   ------------------------------------------------------------ */
function ydc_form_state($type)
{
    ydc_session();

    $state = array(
        'sent'   => false,
        'ref'    => '',
        'name'   => '',
        'errors' => array(),
        'values' => array(),
        'notice' => '',
    );

    /* --- success view after a redirect (PRG pattern) --- */
    if (isset($_GET['sent'])) {
        $ref   = preg_replace('/[^A-Z0-9\-]/', '', strtoupper((string) $_GET['sent']));
        $flash = isset($_SESSION['ydc_flash']) ? $_SESSION['ydc_flash'] : null;

        if ($flash && isset($flash['ref'], $flash['time'])
            && $flash['ref'] === $ref
            && (time() - (int) $flash['time']) < 600) {
            $state['sent'] = true;
            $state['ref']  = $ref;
            $state['name'] = isset($flash['name']) ? $flash['name'] : '';
            return $state;
        }

        return $state;
    }

    /* --- nothing submitted --- */
    if (strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        return $state;
    }

    /* --- upload larger than post_max_size: PHP empties $_POST --- */
    if (empty($_POST) && !empty($_SERVER['CONTENT_LENGTH'])) {
        $state['errors']['_'] = 'The file you selected is too large for the server. Please use a smaller file.';
        return $state;
    }

    if ((isset($_POST['form']) ? $_POST['form'] : '') !== $type) {
        return $state;
    }

    /* --- keep the typed values so the form can be re-filled --- */
    foreach ($_POST as $key => $value) {
        if (is_string($value) && $key !== '_token') {
            $state['values'][$key] = trim($value);
        }
    }

    /* --- bot trap: pretend everything worked --- */
    if (!empty($_POST['website'])) {
        $_SESSION['ydc_flash'] = array(
            'ref'  => 'YDC-000000',
            'name' => '',
            'time' => time(),
        );
        ydc_redirect('?sent=YDC-000000');
    }

    /* --- session expired / forged request --- */
    if (!ydc_csrf_ok()) {
        $state['errors']['_'] = 'Your session expired. Please reload the page and try again.';
        return $state;
    }

    /* --- simple rate limit per session --- */
    $limit = 6;
    $c = ydc_config();
    if (isset($c['uploads']['per_session'])) {
        $limit = (int) $c['uploads']['per_session'];
    }
    $now  = time();
    $hits = isset($_SESSION['ydc_hits']) && is_array($_SESSION['ydc_hits']) ? $_SESSION['ydc_hits'] : array();
    $hits = array_values(array_filter($hits, function ($t) use ($now) {
        return ($now - (int) $t) < 600;
    }));
    if (count($hits) >= $limit) {
        $state['errors']['_'] = 'Too many submissions from this browser. Please wait a few minutes or email us directly.';
        $state['values'] = array();
        return $state;
    }

    /* --- validate --- */
    $rules = ydc_form_rules($type);
    foreach ($rules as $field => $rule) {
        $value = isset($_POST[$field]) ? trim((string) $_POST[$field]) : '';
        $label = isset($rule['label']) ? $rule['label'] : $field;

        if (!empty($rule['required']) && $value === '') {
            $state['errors'][$field] = $label . ' is required.';
            continue;
        }
        if ($value === '') {
            continue;
        }
        if (!empty($rule['email']) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $state['errors'][$field] = 'Enter a valid email, like name@example.com';
            continue;
        }
        if (!empty($rule['phone']) && !preg_match('/^[+0-9][0-9\s\-()]{8,18}$/', $value)) {
            $state['errors'][$field] = 'Enter a valid mobile number, like 0300 1234567';
            continue;
        }
        if (!empty($rule['max']) && ydc_strlen($value) > (int) $rule['max']) {
            $state['errors'][$field] = $label . ' is too long.';
        }
    }

    if (!empty($state['errors'])) {
        return $state;
    }

    /* --- build the record --- */
    if (function_exists('random_bytes')) {
        $rand = bin2hex(random_bytes(4));
    } else {
        $rand = substr(md5(uniqid('', true)), 0, 8);
    }
    $ref = 'YDC-' . strtoupper(substr($rand, 0, 6));

    $record = array(
        'reference'    => $ref,
        'form'         => $type,
        'submitted_at' => gmdate('c'),
        'page'         => basename($_SERVER['PHP_SELF'] ?? ''),
        'ip'           => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
        'user_agent'   => isset($_SERVER['HTTP_USER_AGENT']) ? substr((string) $_SERVER['HTTP_USER_AGENT'], 0, 250) : '',
    );

    foreach ($rules as $field => $rule) {
        $record[$field] = isset($_POST[$field]) ? trim((string) $_POST[$field]) : '';
    }

    /* --- optional CV upload (registration form) --- */
    $upload = ydc_handle_cv_upload($ref);
    if (isset($upload['error'])) {
        $state['errors']['cv'] = $upload['error'];
        return $state;
    }
    if (!empty($upload['file'])) {
        $record['cv_file'] = $upload['file'];
        $record['cv_name'] = $upload['name'];
    }

    $stored = ydc_store($record);
    $mailed = ydc_mail($record, $type);

    if (!$stored && !$mailed) {
        $state['errors']['_'] = 'We could not save your submission right now. Please email ' . ydc_site()['email'] . ' directly.';
        return $state;
    }

    $hits[] = $now;
    $_SESSION['ydc_hits'] = $hits;
    $_SESSION['ydc_flash'] = array(
        'ref'  => $ref,
        'name' => isset($record['name']) ? $record['name'] : '',
        'time' => time(),
    );

    ydc_redirect('?sent=' . rawurlencode($ref));
}

/* ------------------------------------------------------------
   Redirect helper (never returns)
   ------------------------------------------------------------ */
function ydc_redirect($to)
{
    $target = basename($_SERVER['PHP_SELF'] ?? 'index.php') . $to;
    if (!headers_sent()) {
        header('Location: ' . $target, true, 303);
        exit;
    }
    echo '<meta http-equiv="refresh" content="0;url=' . e($target) . '">';
    exit;
}

/* ------------------------------------------------------------
   Storage: one JSON object per line, per month.
   Files live in /data and are blocked from web access.
   ------------------------------------------------------------ */
function ydc_store(array $record)
{
    $config = ydc_forms();
    if (empty($config['store'])) {
        return false;
    }

    $dir = YDC_ROOT . '/data';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    if (!is_dir($dir) || !is_writable($dir)) {
        return false;
    }

    $file = $dir . '/submissions-' . gmdate('Y-m') . '.jsonl';
    $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
    if (defined('JSON_INVALID_UTF8_SUBSTITUTE')) {
        $flags |= JSON_INVALID_UTF8_SUBSTITUTE;
    }

    $line = json_encode($record, $flags);
    if ($line === false) {
        return false;
    }

    $ok = @file_put_contents($file, $line . "\n", FILE_APPEND | LOCK_EX);
    if ($ok !== false) {
        @chmod($file, 0640);
    }
    return $ok !== false;
}

/* ------------------------------------------------------------
   CV upload (registration form)
   Files are stored in /data/cvs with a random name and are
   blocked from web access by .htaccess.
   ------------------------------------------------------------ */
function ydc_cv_max_mb()
{
    $c = ydc_config();
    return isset($c['uploads']['cv_max_mb']) ? (int) $c['uploads']['cv_max_mb'] : 5;
}

function ydc_cv_types()
{
    $c = ydc_config();
    return isset($c['uploads']['cv_types']) && is_array($c['uploads']['cv_types'])
        ? $c['uploads']['cv_types']
        : array('pdf', 'doc', 'docx');
}

function ydc_handle_cv_upload($ref)
{
    if (!isset($_FILES['cv']) || !is_array($_FILES['cv']) || !isset($_FILES['cv']['error'])) {
        return array();
    }

    $file = $_FILES['cv'];
    $code = (int) $file['error'];

    if ($code === UPLOAD_ERR_NO_FILE) {
        return array();
    }
    if ($code === UPLOAD_ERR_INI_SIZE || $code === UPLOAD_ERR_FORM_SIZE) {
        return array('error' => 'The CV is too large. Maximum size is ' . ydc_cv_max_mb() . ' MB.');
    }
    if ($code !== UPLOAD_ERR_OK) {
        return array('error' => 'The CV could not be uploaded. Please try again.');
    }

    $original = isset($file['name']) ? (string) $file['name'] : 'cv';
    $tmp      = isset($file['tmp_name']) ? (string) $file['tmp_name'] : '';
    $size     = isset($file['size']) ? (int) $file['size'] : 0;

    if ($size <= 0 || $size > ydc_cv_max_mb() * 1024 * 1024) {
        return array('error' => 'The CV must be ' . ydc_cv_max_mb() . ' MB or smaller.');
    }
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        return array('error' => 'The CV could not be uploaded. Please try again.');
    }

    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    if (!in_array($ext, ydc_cv_types(), true)) {
        return array('error' => 'Upload the CV as a PDF or Word file (.pdf, .doc, .docx).');
    }

    /* Basic content check so a renamed .exe cannot sneak through. */
    if (function_exists('finfo_open')) {
        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = (string) @finfo_file($finfo, $tmp);
            @finfo_close($finfo);
            $allowed = array(
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/zip',
                'application/octet-stream',
            );
            if ($mime !== '' && !in_array($mime, $allowed, true)) {
                return array('error' => 'That file does not look like a PDF or Word document.');
            }
        }
    }

    $dir = YDC_ROOT . '/data/cvs';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    if (!is_dir($dir) || !is_writable($dir)) {
        return array('error' => 'The upload folder is not writable. Please email your CV to ' . ydc_site()['email'] . '.');
    }

    $safeRef = preg_replace('/[^A-Z0-9\-]/', '', strtoupper((string) $ref));
    $stored  = $safeRef . '-' . substr(hash('sha256', $original . '|' . microtime(true)), 0, 8) . '.' . $ext;
    $target  = $dir . '/' . $stored;

    if (!@move_uploaded_file($tmp, $target)) {
        return array('error' => 'The CV could not be saved. Please try again.');
    }
    @chmod($target, 0640);

    return array('file' => $stored, 'name' => $original);
}

/* ------------------------------------------------------------
   Email notification (optional)
   ------------------------------------------------------------ */
function ydc_mail(array $record, $type)
{
    $config = ydc_forms();
    if (empty($config['to'])) {
        return false;
    }

    /* 'mail' can be false, true (all forms) or a list of form types. */
    $switch = isset($config['mail']) ? $config['mail'] : false;
    if ($switch === true) {
        $enabled = true;
    } elseif (is_array($switch)) {
        $enabled = in_array($type, $switch, true);
    } else {
        $enabled = false;
    }
    if (!$enabled) {
        return false;
    }

    $site = ydc_site();
    $host = isset($_SERVER['HTTP_HOST']) ? preg_replace('/[^A-Za-z0-9\.\-]/', '', $_SERVER['HTTP_HOST']) : 'localhost';
    $from = !empty($config['from']) ? $config['from'] : 'no-reply@' . $host;

    $subject = '[' . $site['name'] . '] ' . ($type === 'registration' ? 'New registration' : 'New contact message')
        . ' — ' . (isset($record['name']) ? $record['name'] : 'visitor')
        . ' (' . $record['reference'] . ')';

    $lines = array();
    foreach ($record as $key => $value) {
        $lines[] = ucfirst(str_replace('_', ' ', $key)) . ': ' . $value;
    }
    $body = implode("\n", $lines) . "\n";

    $headers = array(
        'From: ' . $site['name'] . ' <' . $from . '>',
        'Reply-To: ' . (isset($record['email']) ? $record['email'] : $from),
        'Content-Type: text/plain; charset=UTF-8',
        'X-Mailer: PHP/' . phpversion(),
    );

    return @mail($config['to'], $subject, $body, implode("\r\n", $headers));
}

/* ------------------------------------------------------------
   Small view helpers
   ------------------------------------------------------------ */
function ydc_old(array $state, $field, $default = '')
{
    return isset($state['values'][$field]) ? $state['values'][$field] : $default;
}

function ydc_error(array $state, $field)
{
    return isset($state['errors'][$field]) ? $state['errors'][$field] : '';
}

/**
 * Length without requiring the mbstring extension.
 */
function ydc_strlen($value)
{
    $value = (string) $value;
    if (function_exists('mb_strlen')) {
        return mb_strlen($value, 'UTF-8');
    }
    $count = preg_match_all('/./us', $value, $m);
    return $count === false ? strlen($value) : $count;
}

function ydc_field_class(array $state, $field, $base = 'fld')
{
    return ydc_error($state, $field) !== '' ? $base . ' bad' : $base;
}

function ydc_selected(array $state, $field, $value)
{
    return ydc_old($state, $field) === $value ? ' selected' : '';
}
