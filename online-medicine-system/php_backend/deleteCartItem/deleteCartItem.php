<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data sent via AJAX
  
    $cart_id = intval($_POST['cartId']);


    $updateCartItemSql = "DELETE FROM cartitem WHERE id=$cart_id";;
    $sqlResult = mysqli_query($conn, $updateCartItemSql);
    if ($sqlResult) {

        echo json_encode(["isSuccess" => true, "type" => "update", "data" => [$updateCartItemSql], "message" => "Cart item deleted successfully"]);

    } else {
        echo json_encode(["isSuccess" => false, "type" => "add", "data" => ["error" => mysqli_error($conn)], "message" => "Failed to delete cart item"]);
    }

} else {
    // If the request method is not POST, return an error
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>