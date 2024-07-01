<?php
include "db_conn.php";

if (isset($_POST['update'])) {
    $proID = $_POST['product_id'];

    // Retrieve the product details from the database based on the ID
    $sql = "SELECT * FROM products WHERE proID = '$proID'";
    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $productName = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update products</title>
    <link rel="stylesheet" href="CSS/UploadProduct.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f5;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea {
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Update Product</h1>
        <form action="LogicforUpdate.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $proID; ?>">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" id="product_name" value="<?php echo $productName; ?>" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo $description; ?></textarea><br>
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo $price; ?>" required><br>

            <label for="image">Image :</label>
            <input type="file" name="image" id="image"> <br>

            <button type="submit" name="update_product">Update</button>
        </form>
    </div>
</body>

</html>