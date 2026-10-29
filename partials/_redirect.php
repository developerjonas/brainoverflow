<?php
$categoryId = positive_int($_GET['cat_id'] ?? null);
if ($categoryId === null) {
    header('Location: discussion.php');
    exit();
}
