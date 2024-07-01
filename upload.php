<?php

if (isset($_POST['submit']) && isset($_FILES['my_image'])) {

    include "db_conn.php";

    echo "<pre>";
    print_r($_FILES['my_image']);
    echo "</pre>";

    $pro_name = $_POST['namePro'];
    $pro_price = $_POST['price'];
    $pro_desc = $_POST['description'];
    $img_name = $_FILES['my_image']['name'];
    $tmp_name = $_FILES['my_image']['tmp_name'];
    $img_size = $_FILES['my_image']['size'];
    $error = $_FILES['my_image']['error'];

    if ($error === 0) {
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //gets the the ex[entsion]
        $img_ex_lc = strtolower($img_ex); //makes the exntesion to lower case

        $allowed_exs = array("jpg", "jpeg", "png");

        if (in_array($img_ex_lc, $allowed_exs)) {
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
            $img_upload_path = 'Uploads/' . $new_img_name;
            move_uploaded_file($tmp_name, $img_upload_path);

            // Insert into DB
            $sql = "INSERT INTO products (name, imgURL, price, description) 
VALUES ('$pro_name', '$new_img_name', '$pro_price', '$pro_desc')";

            if (mysqli_query($conn, $sql)) {
                // If the query was successful, redirect with success message
                $em = "Product Added!";
                header("Location: addProduct.html?success=$em");
                exit(); // Make sure to exit after redirecting
            } else {
                // If there was an error in the query, handle it here
                $error_msg = "Error: " . mysqli_error($conn);

            }
        } else {
            $em = "You cant upoad the files of this type";
            header("Location: AddProduct.php?error=$em");
        }
    }

} else {
    header("Location: AddProduct.php");
    echo "Not uploaded";
}
?>