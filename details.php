<?php
include "db_conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            height: 500px;
            margin: 0 auto;
            padding: 100px;
        }

        .product-details {
            display: flex;
            justify-content: center;
            /* Center the content horizontally */
            align-items: center;
            /* Center the content vertically */
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }

        .product-image img {
            max-width: 400px;
            /* Increase the image width */
            height: auto;
            border-radius: 4px;
        }

        .product-info {
            flex: 1;
            padding-left: 20px;
        }

        .product-info h2 {
            margin: 0;
            font-size: 28px;
            /* Increase the font size */
            margin-bottom: 10px;
        }

        .product-info p {
            font-size: 18px;
            /* Increase the font size */
            color: #333;
            margin-bottom: 10px;
        }

        .product-info .price {
            font-size: 24px;
            /* Increase the font size */
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        button {
            padding: 12px 24px;
            /* Increase the padding */
            font-size: 20px;
            /* Increase the font size */
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<?php
if (isset($_GET['product_id'])) {
    $pro_ID = $_GET['product_id'];
    $sql = "SELECT * FROM products WHERE proID = $pro_ID";
    $results = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($results);
    $ori_price = $data['price'];
}
?>

<body>
    <div class="container">
        <div class="product-details">
            <div class="product-image">
                <img src="Uploads/<?php echo $data['imgURL'] ?>" alt="Product Image">
            </div>
            <div class="product-info">
                <h2>
                    <?= $data['name'] ?>
                </h2>
                <p class="price">$
                    <?php echo $ori_price ?>
                </p>
                <p>
                    <?= $data['description'] ?>
                </p>
                <button><a href="jewellery.php?add_to_cart=<?php echo $pro_ID ?>" class=btn>Add to Cart</a></button>
            </div>
        </div>
    </div>

</body>

</html>