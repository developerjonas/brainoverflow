<?php
    session_start();
    session_destroy();
    header('Location: ../../discussion.php');
    exit();
?>