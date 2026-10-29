<?php

$helpersPath = __DIR__ . '/../_helpers.php';
require_once $helpersPath;
start_app_session();

$alert = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../database/_connect.php';
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid form token.');
    }
    $username = $_POST['username'] ?? '';
    $pass = $_POST['pass'] ?? '';
    if (!is_string($username) || !is_string($pass)) {
        http_response_code(400);
        exit('Invalid login details.');
    }

    // Bind credentials as data so login input cannot alter the query.
    $stmt = mysqli_prepare($conn, 'SELECT * FROM `users` WHERE `username` = ?');
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($pass, $user['user_pass'])) {
            // Rotate the session identifier and replace prior role data after login.
            session_regenerate_id(true);
            $_SESSION = [
                'loggedin' => true,
                'role' => 'user',
                'username' => $user['username'],
                'sno' => (int) $user['sno'],
            ];
            header('Location: ../../discussion.php');
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to brainoverflow</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="POST" class="login-form">
                <?php echo csrf_field(); ?>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>

<script src="script.js"></script>

</html>