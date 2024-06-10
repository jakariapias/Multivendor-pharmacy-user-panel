<?php
include('../../config/dbConn.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data sent via AJAX
    $userId=$_SESSION['loggedInId'];
    $product_id = intval($_POST['id']);
    $qty = intval($_POST['qty']);
    $price = intval($_POST['price']);
    $pharmacy_id = intval($_POST['pharmacy_id']);
    $data=array("product_id"=>$product_id,"qty"=>$qty,"price"=>$price);

    $isProductExistQuery="SELECT * FROM cartitem WHERE prod_id = $product_id AND cust_id=$userId";
    $isProductExistResult=mysqli_query($conn, $isProductExistQuery);
    if(mysqli_num_rows($isProductExistResult)> 0) {
        // Product exists, update its quantity
        $row = $isProductExistResult->fetch_assoc();
        $currentQuantity = $row['qty'];
        $newQuantity = $currentQuantity + $qty;

        $updateCartSql = "UPDATE cartitem SET qty = $newQuantity WHERE prod_id = $product_id";
        $updateQueryResult=mysqli_query($conn, $updateCartSql);
        
        if($updateQueryResult) {
            echo json_encode(["isSuccess" => true,"type"=>"update", "data" => [], "message" =>"Cart item updated successfully"]);
        }
        else {
            echo json_encode(["isSuccess" => false,"type"=>"update", "data" => ["error"=>mysqli_error($conn)], "message" => "Failed to update Cart Item"]);
        }
    }else{
        $addToCartQuery = "INSERT INTO cartitem (`prod_id`, `qty`,`price`, `cust_id`,`pharmacy_id`) VALUES ($product_id, $qty, $price,$userId,$pharmacy_id)";
        $result = mysqli_query($conn, $addToCartQuery );
    
        // Example: Display received data
        if ($result === TRUE) {
            echo json_encode(["isSuccess" => true, "type"=>"add", "data" => [], "message" =>"Cart item added successfully"]);
        } else {
            echo json_encode(["isSuccess" => false, "type"=>"add", "data" => ["error"=>mysqli_error($conn)], "message" => "Failed to add Cart Item"]);
        }
    }
        



    // Perform backend processing with the received data
    // Your backend logic here...
    // For example, you can process the received data, update the database, etc.
} else {
    // If the request method is not POST, return an error
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
