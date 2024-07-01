<?php
include "db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f9e0b8;
            /* Light orangey background */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e59853;
            /* Darker orangey border */
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #fbd7a6;
            /* Light orangey container background */
        }

        h1 {
            color: #e59853;
            /* Darker orangey heading color */
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #e59853;
            /* Darker orangey border for input fields */
            border-radius: 5px;
        }

        .payment-method {
            border: 1px solid #e59853;
            /* Darker orangey border for payment method section */
            background-color: #f9d49b;
            /* Lighter orangey background for payment method section */
            border-radius: 5px;
            padding: 10px;
        }

        .payment-method label {
            display: block;
            margin-bottom: 5px;
        }

        .payment-method input[type="radio"] {
            margin-right: 5px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #f79e0f;
            /* Dark orangey button color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #f9ad41;
            /* Slightly lighter orangey button color on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Checkout</h1>
        <form action="checkOutDetailsLogic.php" method="post">
            <label for="email">email:</label>
            <input type="email" id="email" name="email" placeholder="Please enter the email u logged in" required>

            <label for="street">Street Address:</label>
            <input type="text" id="street" name="street" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>

            <label for="telephone">Telephone:</label>
            <input type="tel" id="telephone" name="telephone" required>

            <div class="payment-method">
                <label>Payment Method:</label>
                <input type="radio" id="credit-card" name="payment_method" value="credit_card" required>
                <label for="credit-card">Credit Card</label>

                <input type="radio" id="paypal" name="payment_method" value="paypal" required>
                <label for="paypal">PayPal</label>
            </div>
            <br><br>
            <!-- Hidden input fields for product IDs and quantities -->
            <?php
            $sql = 'SELECT * FROM cart_table';
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                while ($dbData = mysqli_fetch_assoc($res)) {
                    $pro_id = $dbData['proID'];
                    ?>
                    <input type="hidden" name="product_ids[]" value="<?php echo $pro_id; ?>">
                    <!-- Quantity input fields -->
                    <input type="hidden" value="" name="order_quantity[]">
                    <?php
                }
            }
            ?>
            <button type="submit" class="btn">Submit Order</button>
        </form>
    </div>
</body>

</html>