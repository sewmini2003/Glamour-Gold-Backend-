<?php
session_start();
include 'db_conn.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['u_email'] = $u_email; 
    header("Location:index.html");
} else {
    header("Location:login.html");
}
?>