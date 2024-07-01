<?php
// Assuming you have already established a database connection
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $tp = $_POST["telephone"];
    $message = $_POST["msg"];

    // Prepare the SQL statement to insert the data into the contact table
    $insertSql = "INSERT INTO contact (name, email, subject, msg) VALUES ('$name', '$email', '$tp', '$message')";

    // Execute the SQL statement
    if (mysqli_query($conn, $insertSql)) {
        header("Location:index.html");
    } else {
        echo "Error sending the message: " . mysqli_error($conn);
    }
}
?>
