<?php

require_once __DIR__ . '/../_helpers.php';
start_app_session();

$alert = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../database/_connect.php';
    if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        exit('Invalid form token.');
    }
    $name = $_POST['name'] ?? '';
    $pass = $_POST['pass'] ?? '';
    if (!is_string($name) || !is_string($pass)) {
        http_response_code(400);
        exit('Invalid login details.');
    }

    // Bind credentials as data so login input cannot alter the query.
    $stmt = mysqli_prepare($conn, 'SELECT * FROM `admin` WHERE `name` = ?');
    mysqli_stmt_bind_param($stmt, 's', $name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($pass, $admin['pass'])) {
            // Rotate the session identifier and replace prior role data after login.
            session_regenerate_id(true);
            $_SESSION = [
                'loggedin' => true,
                'role' => 'admin',
                'name' => $admin['name'],
                'sno' => (int) $admin['sno'],
            ];
            header('Location: panel/index.php');
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('admin not found');</script>";
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
                <input type="text" name="name" placeholder="Username" required>
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>

<script src="script.js"></script>

</html>