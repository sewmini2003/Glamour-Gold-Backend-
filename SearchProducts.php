<?php
include "db_conn.php"
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search, Delete, Update PRODUCTS</title>
    <link rel="stylesheet" href="CSS/SearchProduct.css" type="text/CSS">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .search {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .search input[type="text"] {
            padding: 8px;
            font-size: 16px;
        }

        .search button {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .tableCon {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table img {
            max-width: 80px;
            max-height: 80px;
        }

        .update,
        .delete {
            padding: 5px 10px;
            font-size: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .update:hover,
        .delete:hover {
            background-color: #45a049;
        }

        .NoData {
            text-align: center;
            margin-top: 20px;
            color: #f44336;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 align=center>SEARCH PRODUCTS </h1>
        <form action="" method="post" class="search">
            <input type="text" placeholder="Search Item" name=search>
            <button name=submit>Search</button>
        </form>
        <div class="tableCon">
            <table class=table>
                <?php
                if (isset($_POST['submit'])) {
                    $search = $_POST['search'];

                    $sql = "SELECT * FROM products where proID like '%$search%' or name like '%$search%'";

                    $results = mysqli_query($conn, $sql);

                    if ($results) {

                        if (mysqli_num_rows($results) > 0) {
                            echo '
            <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>imgURL</th>
                <th>desciption</th>
                <th>price</th>
                <th>UPDATE</th>
                <th>DELETE</th>
            </tr>
            </thead>';

                            while ($row = mysqli_fetch_assoc($results)) {
                                echo '
                            <tbody>
                                <tr>
                                        <td>' . $row['proID'] . '</td>
                                        <td>' . $row['name'] . '</td>
                                        <td> <img src = "Uploads/' . $row['imgURL'] . '"></td>
                                        <td>' . $row['description'] . '</td>
                                        <td>' . $row['price'] . '</td>
                                        <form action="UpdateProducts.php" method="post">
                                         <input type="hidden" name="product_id" value="' . $row['proID'] . '">
                                         <td> <button type = "submit" class = "update" name = "update">  Update </button> </td>
                                        </form>
                                    <td>
                                        <form action="deleteProduct.php" method="post">
                                         <input type="hidden" name="product_id" value="' . $row['proID'] . '">
                                         <button type="submit" name="delete" class = "delete">Delete</button>
                                        </form>
                                    </td>
                                    </tr>
                            </tbody>';
                            }
                        } else {
                            echo '<h2 class = "No Data">Product Not Found</h2>';
                        }
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>