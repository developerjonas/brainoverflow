<?php
if (!isset($_GET['cat_id'])) {
    header('Location: discussion.php'); // Redirect to your main discussion page
    exit(); // Always call exit after redirect to stop further script execution
}
