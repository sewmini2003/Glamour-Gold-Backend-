<?php
include "db_conn.php";


function getIPAddress()
{
    //whether ip is from the share internet  
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address  
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
// $ip = getIPAddress();  
// echo 'User Real IP Address - '.$ip;  

function cart()
{
    error_reporting(E_ALL); // Enable error reporting

    if (isset($_GET['add_to_cart'])) {
        global $conn;

        $ip = getIPAddress();
        $get_pro_id = $_GET['add_to_cart'];
        $selectsql = "SELECT * FROM cart_table WHERE IPaddress = '$ip' AND proID = $get_pro_id";

        $results = mysqli_query($conn, $selectsql);
        if (!$results) {
            echo "Error in SELECT query: " . mysqli_error($conn);
        } else {
            $rows = mysqli_num_rows($results);
            if ($rows > 0) {
                echo "<script>alert('The item is already in the cart')</script>";
                header("Location: jewellery.php");
            } else {
                $sqlInsert = "INSERT INTO cart_table VALUES ($get_pro_id, '$ip', 1)";
                if (mysqli_query($conn, $sqlInsert)) {
                    header("Location: login.php");
                } else {
                    echo "Error in INSERT query: " . mysqli_error($conn);
                }
            }
        }
    }
}


//total cart price

//total cart price
function total_Cart()
{
    global $conn;

    $getiP = getIPAddress();
    $total = 0;
    $sqlCartQuery = "SELECT * FROM cart_table WHERE IPaddress = '$getiP'"; //can it to email in the future

    $result = mysqli_query($conn, $sqlCartQuery);

    if (!$result) {
        echo "Error in SQL query: " . mysqli_error($conn);
    } else {
        while ($row = mysqli_fetch_array($result)) {
            $proID = $row['proID'];
            $sqlSelectPro = "SELECT * FROM products WHERE proID = $proID";
            $res_prod = mysqli_query($conn, $sqlSelectPro);
            if (!$res_prod) {
                echo "Error in SQL query: " . mysqli_error($conn);
            } else {
                while ($row_pro_price = mysqli_fetch_array($res_prod)) {
                    $pro_price_arr = array($row_pro_price['price']);
                    $pro_price_arr_total = array_sum($pro_price_arr);
                    $total += $pro_price_arr_total;
                }
            }
        }
        echo $total;
    }
}

function addOrderToTable($conn)
{
    $email = $_SESSION['u_email'];
    $cusID = uniqid(); // Generate a unique customer ID

    // Fetch the cart data for the logged-in user
    $sqlCart = "SELECT * FROM cart_table WHERE IPaddress = '$email'";
    $resultCart = mysqli_query($conn, $sqlCart);

    while ($rowCart = mysqli_fetch_assoc($resultCart)) {
        $proID = $rowCart['proID'];
        $quantity = $rowCart['quantity'];

        // Fetch the product details from the products table
        $sqlProduct = "SELECT proName, imgURL, newPrice FROM products WHERE ID = $proID";
        $resultProduct = mysqli_query($conn, $sqlProduct);
        $rowProduct = mysqli_fetch_assoc($resultProduct);

        $proName = $rowProduct['proName'];
        $imgURL = $rowProduct['imgURL'];
        $newPrice = $rowProduct['newPrice'];

        // Insert the order into the orders table
        $sqlInsert = "INSERT INTO orders (proName, imgURL, quantity, newPrice, email, cusID) 
                      VALUES ('$proName', '$imgURL', $quantity, $newPrice, '$email', '$cusID')";
        mysqli_query($conn, $sqlInsert);
    }

    // Clear the cart for the logged-in user
    $sqlClearCart = "DELETE FROM cart_table WHERE IPaddress = '$email'";
    mysqli_query($conn, $sqlClearCart);
}
?>


<!-- TO BE NOTED, THE CART QUANTITY IS NOT ADDED, AND ALSO THE BUY NOW FUNCTION DOES NOT ADD VALUES TO THE DATABSE 
LOOK INTO IT AS WELL
HAPPY CODING -->