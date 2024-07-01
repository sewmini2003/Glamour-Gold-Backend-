<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succes Page</title>
    <style>
        body{
            background-color: #F2F4F5;
        }
    </style>
</head>
<body>
    
</body>
</html>
<?php
// Assuming you have already established a database connection
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $postal_code = $_POST["postal_code"];
    $telephone = $_POST["telephone"];

    // Concatenate address details into one variable
    $address = $street . ", " . $city . ", " . $postal_code;

    // SQL query to check if the email exists in the "users" table
    $checkEmailSql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailSql);

    if (mysqli_num_rows($result) > 0) {
        // Email exists in the table, perform the update
        $updateSql = "UPDATE users SET address = '$address', telephone = '$telephone' WHERE email = '$email'";
        $getIdSql = "SELECT * FROM users WHERE email = '$email'";

        if (mysqli_query($conn, $updateSql)) {
            echo "
            <div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>
        <img src='images/order-done.png'>
      </div>";


            // Get the user ID from the users table
            $userResult = mysqli_query($conn, $getIdSql);
            $userData = mysqli_fetch_assoc($userResult);
            $uID = $userData['id'];

            // Select product IDs and quantities from the cart_table
            $selectCartSql = "SELECT proID, quantity FROM cart_table";
            $cartResult = mysqli_query($conn, $selectCartSql);

            // Get the current time and date
            $currentDateTime = date("Y-m-d H:i:s");

            while ($cartData = mysqli_fetch_assoc($cartResult)) {
                $pro_id = $cartData['proID'];
                $quantity = $cartData['quantity'];

                // Insert the order details into the orders table
                $insertOrderSql = "INSERT INTO orders (proID, quantity, userID, time) VALUES ('$pro_id', '$quantity', $uID, '$currentDateTime')";

                if (!mysqli_query($conn, $insertOrderSql)) {
                    echo "Error inserting order details: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error updating user address and telephone: " . mysqli_error($conn);
        }
    } else {
        // Email not found, show an alert
        echo '<script>alert("Email not found in the database."); window.location.href = "ConfirmOrder.php";</script>';
    }
}
?>