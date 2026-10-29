<?php
require_once __DIR__ . '/../../_auth.php';
require '../../../../partials/database/_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Invalid form submission.');
}

$cat_id = positive_int($_POST['id'] ?? null);
$name = $_POST['name'] ?? '';
$desc = $_POST['desc'] ?? '';
if ($cat_id === null || !is_string($name) || !is_string($desc) || trim($name) === '') {
    http_response_code(400);
    exit('Invalid category details.');
}

// Update category fields with bound values after validating the submitted identifier.
$statement = mysqli_prepare($conn, 'UPDATE `categories` SET `ct_name` = ?, `ct_desc` = ? WHERE ct_id = ?');
mysqli_stmt_bind_param($statement, 'ssi', $name, $desc, $cat_id);
mysqli_stmt_execute($statement);
header('Location: ../categories.php');
exit();
?>
