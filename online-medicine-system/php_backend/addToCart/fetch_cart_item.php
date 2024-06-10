<?php
include('../../config/dbConn.php');
session_start();

$isUserLoggedIn = isset($_SESSION['loggedInId']);
$itemCount = 0;
$userId = null;

if ($isUserLoggedIn) {
   
    $userId = $_SESSION['loggedInId'];
    
    $cartItemSql = "SELECT c.id, p.prd_name, p.prd_price,p.prd_image, c.qty
        FROM cartitem c
        JOIN product p ON c.prod_id = p.prd_id
        WHERE c.cust_id = $userId";

    $cartItemResult = mysqli_query($conn, $cartItemSql);
    if ($cartItemResult) {
        $itemCount = mysqli_num_rows($cartItemResult);
    }
}

if ($itemCount > 0) {
    while ($row = mysqli_fetch_array($cartItemResult)) {
        $cartId = $row['id'];
        $product_name = $row['prd_name'];
        $product_image = $row['prd_image'];
        $product_price = $row['prd_price'];
        $quantity = $row['qty'];

        $imgSrc = '../pipharm-admin-panel/assets/images/product/' . $product_image;
        ?>

        <div id='<?=$cartId?>'>
            <div class='d-flex justify-content-between align-items-center bg-white p-2 shadow mb-4'>

                <!-- image  -->
                <div class='p-2 bir img-thumbnail'><img src=<?= $imgSrc ?> alt='' style='height:60px'></div>

                <!-- inputs  -->
                <div class='d-flex flex-column justify-content-center px-3' style='min-height:75px'>
                    <p style='line-height:0px;font-weight:600' class='text-center fs-5'>
                        <?= $product_name ?>
                    </p>
                    <div class='input-group' id=<?= 'editCartItem_' . $cartId ?>>
                        <div class='input-group-prepend' id=<?= 'plus_' . $cartId ?> style='display:none'>
                            <span class='input-group-text btn-number' onclick="clickCartItemIncDecBtn(event,this)" data-type='minus' data-field=<?= 'qty_'. $cartId ?>><i
                                    class='fas fa-minus'></i></span>
                        </div>
                        <input type='text' class='form-control text-center' aria-label='Amount (to the nearest dollar)'
                            id=<?= 'qty_' . $cartId ?> style='height:30px;' value=<?= $quantity ?> readonly>

                        <div class='input-group-append' id=<?= 'minus_' . $cartId ?> style='display:none'>
                            <span class='input-group-text btn-number' onclick="clickCartItemIncDecBtn(event,this)"  data-type='plus' data-field=<?= 'qty_' . $cartId ?>> <i
                                    class='fas fa-plus'></i></span>
                        </div>
                    </div>
                </div>

                <!-- //actions -->
                <div id=<?= 'actionOpt_' . $cartId ?>>
                    <i class='fa-regular fa-pen-to-square text-primary' onclick=<?php echo "clickEditCartItem($cartId)" ?>></i>
                    <i class='fa-solid fa-trash text-danger' onclick="clickDeleteCartItem(<?php echo $cartId; ?>, '<?php echo $product_name; ?>')"></i>
                </div>

                <div id=<?= 'back_' . $cartId ?> style='display:none'>
                    <i class='fa-regular fa-circle-xmark' style="color:red" onclick=<?php echo "cancelUpdateCartItem($cartId,$quantity)" ?>></i>
                    <i class='fa-regular fa-circle-check' style="color:green" onclick=<?php echo "updateCartItem($cartId,$quantity)" ?>></i>
                </div>
            </div>
        </div>
        <?Php

    }
} else {
    echo "<h1>Your cart is empty.</h1>";
}

?>