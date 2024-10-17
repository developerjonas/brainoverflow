<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'brainoverflow';

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    echo('<script>alert("Couldnt connect to database")</script>');
}