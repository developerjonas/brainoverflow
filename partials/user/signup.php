<?php

$alert = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../database/_connect.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $c_pass = $_POST['password'];
    $pass = $_POST['pass'];

    // check whether this email or username already exists

    $already_exists = "SELECT * FROM `users` where user_email = '$email' AND username = '$username'";
    $ae_result = mysqli_query($conn, $already_exists);
    $num_rows = mysqli_num_rows($ae_result);
    if ($num_rows > 0) {
        $alert = "Email already in use";
    } else {
        if ($pass = $c_pass) {
            $hash = password_hash($c_pass, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `users` (`user_email`, `username`, `user_pass`, `user_dt`) VALUES ('$email','$username','$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $alert = true;
                header("Location: login.php?signupsuccess=true");
                exit();
            }
        } else {
            echo "<script>alert('Must be same password');</script>";
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
                <input type="email" name="email" placeholder="Email" require>
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