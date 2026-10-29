<?php
require_once __DIR__ . '/../_auth.php';

// Check if the user is logged in
if (($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Welcome, <?php echo h($_SESSION['name'] ?? 'Admin'); ?>!</h2>
            <p>You have successfully logged in.</p>
            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>
