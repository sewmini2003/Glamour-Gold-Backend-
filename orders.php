<?php
// Assuming you have already established a database connection
include "db_conn.php";

// Fetch order details from the database
$sql = "SELECT orders.proID AS product_id, products.name AS product_name, 
 orders.quantity, users.id AS user_id,
  users.address, orders.time
        FROM orders
        JOIN products ON orders.proID = products.proID
        JOIN users ON orders.userID = users.id";
$result = mysqli_query($conn, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Order Table</h1>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>User ID</th>
            <th>Address</th>
            <th>Time</th>
        </tr>
        <?php foreach ($orders as $order) { ?>
            <tr>
                <td>
                    <?php echo $order['product_id']; ?>
                </td>
                <td>
                    <?php echo $order['product_name']; ?>
                </td>
                <td>
                    <?php echo $order['quantity']; ?>
                </td>
                <td>
                    <?php echo $order['user_id']; ?>
                </td>
                <td>
                    <?php echo $order['address']; ?>
                </td>
                <td>
                    <?php echo $order['time']; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>
