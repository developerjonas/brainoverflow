<?php

require_once dirname(__DIR__) . '/_helpers.php';
start_app_session();

// Admin pages require the explicit role set only after admin authentication.
if (($_SESSION['loggedin'] ?? false) !== true || ($_SESSION['role'] ?? '') !== 'admin') {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $adminPath = strpos($scriptName, '/partials/admin/');
    $appRoot = $adminPath === false ? '' : substr($scriptName, 0, $adminPath);
    header('Location: ' . $appRoot . '/partials/admin/login.php');
    exit();
}
