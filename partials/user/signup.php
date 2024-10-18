<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['pass'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['pass'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $insert = "INSERT INTO   `users` (`name`, `email`, `username`, `password`) VALUES ('$name', '$email', '$username', '$hash')";
    $result = mysqli_query($conn, $insert);

    if (!$result) {
        echo "<script>alert('The data wasn't inserted for some reasons')</script>";
        die(mysqli_error($conn));
    } else {
        // Redirect to welcome page after successful signup
        session_start();
        $_SESSION['username'] = $username;
        header('Location: welcome.php');
        exit();
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
            <h2>Signup</h2>
            <form action="signup.php" method="POST" class="signup-form">
                <input type="text" name="name" placeholder="Full Name" required>
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
<?php
require 'db.php';
?>