<?php

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['pass'])) {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    // Retrieve user from database
    $query = "SELECT * FROM `users` WHERE `username` = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: welcome.php');
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
    <title>Login & Signup Form</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="POST" class="login-form">
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