<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pharmacy_id_list = explode(",", $_POST["pharmacy_id_list"]);
    $user_id = $_POST["user_id"];
    $payment_method = $_POST["payment_method"];
    $flag = 0;

    foreach ($pharmacy_id_list as $id) {
        $sql_getCartItem = "SELECT * from cartitem WHERE `cust_id`=$user_id AND pharmacy_id=$id";
        $result_getCartItem = mysqli_query($conn, $sql_getCartItem);
        $cartItem_row_count = mysqli_num_rows($result_getCartItem);
        $orderCode = 'ORD@' . $user_id . '-' . $id . '-' . time();
        $allCartItemId = '';
        $total_sale_amount = 0;

        if ($cartItem_row_count > 0) {
            while ($row_getCartItem = mysqli_fetch_array($result_getCartItem)) {
                $cartItemId = $row_getCartItem['id'];
                $qty = $row_getCartItem['qty'];
                $product_id = $row_getCartItem['prod_id'];
                $subTotal = $row_getCartItem['price'] * $qty;
                $total_sale_amount = $total_sale_amount + $subTotal;

                $sql_setOrderItems = "INSERT INTO orderitems (`order_code`, `prod_id`,`qty`, `subTotal`) VALUES ('$orderCode', $product_id, $qty,$subTotal)";
                $result_setOrderItems = mysqli_query($conn, $sql_setOrderItems);


                $allCartItemId = $allCartItemId . ',' . $cartItemId;

                if ($result_setOrderItems) {

                    $sql_update_product_quantity = "UPDATE product
                    SET quantity = quantity - $qty
                    WHERE prd_id = $product_id";

                    $result_update_product_quantity = mysqli_query($conn, $sql_update_product_quantity);
                    if ($result_update_product_quantity) {
                        $flag = 1;
                    } else {
                        $flag = 0;
                    }


                } else {
                    $flag = 0;
                }
            }

            $sql_setOrder = "INSERT INTO orders (`order_code`,`pharmacy_id`,`cust_id`,`contact_no`,`total_items`,`sale_amount`,`tax`,`shipping_cost`,`shipping_address`,`delivery_option`,`delivery_status`,`order_status`,`payment_method`,`order_type`) VALUES ('$orderCode', $id, $user_id,'',$cartItem_row_count,$total_sale_amount,'','','','','pending','pending','$payment_method','online')";

            $result_setOrderItems = mysqli_query($conn, $sql_setOrder);
            if ($result_setOrderItems) {
                $allCartItemId = ltrim($allCartItemId, ',');
                $deleteCartItemSQL = "DELETE FROM cartitem WHERE `cust_id` = $user_id AND `id` IN ($allCartItemId)";
                $result_deleteCartItem = mysqli_query($conn, $deleteCartItemSQL);
                if ($result_deleteCartItem) {
                    echo "cart item deleted";
                } else {
                    echo "cart item not deleted";
                }

            } else {
                echo "order not added" . " " . $deleteCartItemSQL;
            }



        } else {
            echo "cart item not found";
        }



    }
    if ($flag) {
        $_SESSION['order_status'] = true;
        $_SESSION['pharmacy_list'] = $pharmacy_id_list;
        header("Location: ../../user-profile.php");
    } else {
        $_SESSION['order_status'] = false;
        header("Location: ../../user-profile.php");
    }

} ?>