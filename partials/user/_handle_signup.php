<?php
$alert = "false";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    include '../database/_connect.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $c_pass = $_POST['password'];
    $pass = $_POST['pass'];

    // check whether this email or username already exists

    $already_exists = "SELECT * FROM `users` where user_email = '$email' AND username = '$username'";
    $ae_result = mysqli_query($conn, $already_exists);
    $num_rows = mysqli_num_rows($ae_result);
    if($num_rows > 0){
        $alert = "Email already in use";
    }
    else{
        if($pass = $c_pass){
            $hash = password_hash($c_pass, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `users` (`user_email`, `username`, `user_pass`, `user_dt`) VALUES ('$email','$username','$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if($result){
                $alert = true;
                header("Location: ../../index.php?signupsuccess=true");
                exit();
            }

        }
        else{
            $alert = "Password must be same";
        }
    }
    header("Location: ../../index.php?signupsuccess=false&error=$alert");
}