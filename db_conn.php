<?php

$hostname = "localhost";
$uname = "root";
$password = "";

$db_name = "food";

$conn = mysqli_connect($hostname, $uname, $password, $db_name);

if(!$conn){
    echo "Conn failed";
    exit();
}

?>