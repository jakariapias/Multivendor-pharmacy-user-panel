<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data sent via AJAX
    $userId = $_SESSION['loggedInId'];
    $cart_id = intval($_POST['cartId']);
    $qty = intval($_POST['qty']);

    $updateCartItemSql = "UPDATE cartitem SET qty = $qty WHERE `cust_id` = $userId";
    $sqlResult = mysqli_query($conn, $updateCartItemSql);
    if ($sqlResult) {

        echo json_encode(["isSuccess" => true, "type" => "update", "data" => [$updateCartItemSql], "message" => "Cart item updated successfully"]);

    } else {
        echo json_encode(["isSuccess" => false, "type" => "add", "data" => ["error" => mysqli_error($conn)], "message" => "Failed to update Cart Item"]);
    }

} else {
    // If the request method is not POST, return an error
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>