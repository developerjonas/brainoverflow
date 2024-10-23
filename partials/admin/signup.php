<?php

$alert = "false";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include '../database/_connect.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $c_pass = $_POST['password'];
    $pass = $_POST['pass'];

    // check whether this email or username already exists

    $already_exists = "SELECT * FROM `admin` where email = '$email' AND name = '$name'";
    $ae_result = mysqli_query($conn, $already_exists);
    $num_rows = mysqli_num_rows($ae_result);
    if ($num_rows > 0) {
        $alert = "Email already in use";
    } else {
        if ($pass = $c_pass) {
            $hash = password_hash($c_pass, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `admin` (`email`, `name`, `pass`, `dt`) VALUES ('$email','$name','$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $alert = true;
                header("Location: login.php");
                exit();
            }
        } else {
            echo "<script>alert('Must be same Password');</script>";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Signup</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">
        <div class="form-container">
            <h2>Signup</h2>
            <form action="signup.php" method="POST" class="signup-form">
                <input type="email" name="email" placeholder="Email" require>
                <input type="text" name="name" placeholder="name" required>
                <input type="password" name="pass" placeholder="Password" required>
                <input type="password" name="password" placeholder="Confirm Password" required>
                <button type="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </div>
    </div>

    <script src="script.js"></script>

</html>