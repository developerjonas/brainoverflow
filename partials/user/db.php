<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$databse = 'jonas_db';

$conn = mysqli_connect($servername, $username, $password, $databse);

if (!$conn) {
    echo "<script>alert('Couldnt connect to server')</alert>";
}