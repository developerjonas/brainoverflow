<?php

require_once '../partials/_helpers.php';
start_app_session();
require '../partials/database/_connect.php';

// Only the signed-in owner may delete a comment.
if (($_SESSION['role'] ?? '') !== 'user' || !isset($_SESSION['sno'])) {
    http_response_code(403);
    exit('Sign in with the account that owns this comment.');
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    exit('Invalid form submission.');
}

$commentId = positive_int($_POST['cmt_id'] ?? null);
if ($commentId === null) {
    http_response_code(404);
    exit('Comment not found.');
}

$userId = (int) $_SESSION['sno'];
$statement = mysqli_prepare($conn, 'SELECT th_id FROM `comments` WHERE cmt_id = ? AND cmt_user_id = ?');
mysqli_stmt_bind_param($statement, 'ii', $commentId, $userId);
mysqli_stmt_execute($statement);
$comment = mysqli_fetch_assoc(mysqli_stmt_get_result($statement));
if (!$comment) {
    http_response_code(404);
    exit('Comment not found.');
}

// Include ownership again in the mutation so access cannot change between checks.
$delete = mysqli_prepare($conn, 'DELETE FROM `comments` WHERE cmt_id = ? AND cmt_user_id = ?');
mysqli_stmt_bind_param($delete, 'ii', $commentId, $userId);
mysqli_stmt_execute($delete);
header('Location: ../thread.php?th_id=' . (int) $comment['th_id']);
exit();
