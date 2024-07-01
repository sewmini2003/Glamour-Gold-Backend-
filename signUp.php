 <!-- Purpose: Register a new user -->
<?php
session_start();
include 'db_conn.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
$result = mysqli_query($conn, $query);

if ($result) {
    $_SESSION['username'] = $username;
    header("Location: index.html");
    echo "Success";
} else {
    header("Location: signup.html");
}
?>