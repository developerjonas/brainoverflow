<?php
require_once __DIR__ . '/../../_auth.php';
require '../../../../partials/database/_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Invalid form submission.');
}

$cat_id = positive_int($_POST['cat_id'] ?? null);
if ($cat_id === null) {
    http_response_code(400);
    exit('Invalid category.');
}

// Deletion is a CSRF-checked POST and uses a bound identifier.
$statement = mysqli_prepare($conn, 'DELETE FROM `categories` WHERE `ct_id` = ?');
mysqli_stmt_bind_param($statement, 'i', $cat_id);
mysqli_stmt_execute($statement);
header('Location: ../categories.php');
exit();
?>
