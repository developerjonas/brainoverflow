<?php

require_once __DIR__ . '/../_helpers.php';
start_app_session();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../database/_connect.php';
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid form token.');
    }
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $c_pass = $_POST['password'] ?? '';
    $pass = $_POST['pass'] ?? '';
    if (
        !is_string($username)
        || !is_string($email)
        || !is_string($c_pass)
        || !is_string($pass)
        || trim($username) === ''
        || strlen($username) > 64
        || strlen($email) > 64
        || $pass === ''
        || strlen($pass) > 72
        || !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        http_response_code(400);
        exit('Invalid signup details.');
    }

    // Reject either duplicate identifier before creating the account.
    $already_exists = mysqli_prepare($conn, 'SELECT 1 FROM `users` WHERE user_email = ? OR username = ? LIMIT 1');
    mysqli_stmt_bind_param($already_exists, 'ss', $email, $username);
    mysqli_stmt_execute($already_exists);
    $ae_result = mysqli_stmt_get_result($already_exists);
    $num_rows = mysqli_num_rows($ae_result);
    if ($num_rows > 0) {
        http_response_code(409);
        exit('That email address or username is already in use.');
    } else {
        if ($pass === $c_pass) {
            $hash = password_hash($c_pass, PASSWORD_BCRYPT);
            $stmt = mysqli_prepare($conn, 'INSERT INTO `users` (`user_email`, `username`, `user_pass`, `user_dt`) VALUES (?, ?, ?, current_timestamp())');
            mysqli_stmt_bind_param($stmt, 'sss', $email, $username, $hash);
            mysqli_stmt_execute($stmt);
            if (mysqli_stmt_affected_rows($stmt) !== 1) {
                throw new RuntimeException('User signup did not create exactly one account.');
            }
            header("Location: login.php?signupsuccess=true");
            exit();
        } else {
            http_response_code(400);
            exit('Passwords do not match.');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup to brainoverflow</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2>Signup</h2>
            <form action="signup.php" method="POST" class="signup-form">
                <?php echo csrf_field(); ?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="pass" placeholder="Password" required>
                <input type="password" name="password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>

</html>