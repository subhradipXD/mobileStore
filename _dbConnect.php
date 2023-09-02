<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "mobilestore";

$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn){
    echo "Connection is not established<br>";
}else{
    echo "connection is established<br>";
}
?>