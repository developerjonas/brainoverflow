<?php

$alert = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    require '../database/_connect.php';
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    // Retrieve user from database
    $query = "SELECT * FROM `admin` WHERE `name` = '$name'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($pass, $user['pass'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $name;
            $_SESSION["sno"] = $admin['sno'];
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
                <input type="text" name="name" placeholder="Username" required>
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>

<script src="script.js"></script>

</html>