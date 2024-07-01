<?php
session_start();
include "db_conn.php";
include "function.php";
?>
<!-- removes data from the cart  -->
<?php
if (isset($_GET['remove'])) {
    $remove_pro_id = $_GET['remove'];
    $sqlRemove = "DELETE FROM cart_table WHERE proID = $remove_pro_id";
    if (mysqli_query($conn, $sqlRemove)) {
        header("Location: cart.php");
    } else {
        echo "Error removing item from cart: " . mysqli_error($conn);
    }

}

if (isset($_POST['buy_all'])) {
    // Get the order quantities from the form
    $order_quantities = $_POST['order_quantity'];

    // Update cart_table with the new quantities
    $sql = 'SELECT * FROM cart_table';
    $res = mysqli_query($conn, $sql);
    // if (mysqli_num_rows($res) > 0) {
    //     while ($dbData = mysqli_fetch_assoc($res)) {
    //         $pro_id = $dbData['proID'];
    //         $new_quantity = (int) $order_quantities; // Get the new quantity from the form
    //         $sqlUpdateQuantity = "UPDATE cart_table SET quantity = 1 WHERE proID = $pro_id";
    //         mysqli_query($conn, $sqlUpdateQuantity);
    //     }
    // }

    // Redirect to ConfirmOrder.php after updating quantities
    header("Location: ConfirmOrder.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: center;
            /* align-items: center; */
            max-height: fit-content;
            /* width: ; */
        }

        #cart {
            border: 1px solid #ddd;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        #total {
            font-size: 18px;
            font-weight: bold;
        }

        #buy-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #buy-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1 align=center>My Shopping Cart</h1>
    <div class="container">
        <div id="cart">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <!-- fetch data from cart table -->
                <?php
                $sql = 'SELECT * FROM cart_table';
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) > 0) {
                    while ($dbData = mysqli_fetch_assoc($res)) {
                        $pro_id = $dbData['proID'];
                        $sqlProductTbl = "SELECT name, imgURL, price FROM products WHERE proID = $pro_id";
                        $result = mysqli_query($conn, $sqlProductTbl);
                        $proDetails = mysqli_fetch_assoc($result);

                        $pro_name = $proDetails['name'];
                        $pro_price = $proDetails['price'];
                        $pro_img = $proDetails['imgURL']; ?>
                        <tr>
                            <td>
                                <div class="cart-details">
                                    <img src="Uploads/<?php echo $pro_img ?>" width=150px alt="">
                                    <div>
                                        <p>
                                            <?php echo $pro_name ?>
                                        </p>
                                        <br>
                                        <a href="cart.php?remove=<?php echo $pro_id ?>">Remove</a>
                                    </div>
                                </div>
                            </td>
                            <!-- Hidden input field to store the product ID -->
                            <td>x $
                                <input type="hidden" name="product_ids[]" value="<?php echo $pro_id; ?>">
                                <input type="number" value="1" name="order_quantity">
                                <?php
                                echo $pro_price;
                                ?>
                            </td>
                        </tr>

                    <?php }
                } ?>
            </table>
            <p id="total">Total:
                <?php total_Cart() ?>
            </p>
            <form action="cart.php" method="post">
                <button id="buy-button" name=buy_all>Buy All</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>