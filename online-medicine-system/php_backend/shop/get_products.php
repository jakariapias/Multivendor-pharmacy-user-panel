<?php
include("../../config/dbConn.php");
session_start();
$userId = isset($_SESSION["loggedInId"]) ? $_SESSION["loggedInId"] : -1;
$pharmacy_id = isset($_POST["shopId"]) ? $_POST["shopId"] : 0;
$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : null;
$sub_category_id = isset($_POST['sub_category_id']) ? $_POST['sub_category_id'] : null;



$fetch_product_sql1 = "SELECT * from product WHERE `pharmacy_id`=$pharmacy_id";
$fetch_product_sql2 = "SELECT * from product WHERE `pharmacy_id`=$pharmacy_id AND `prd_cat_id`=$category_id";
$fetch_product_sql3 = "SELECT * from product WHERE pharmacy_id=$pharmacy_id AND `prd_cat_id`=$category_id AND `prd_sub_cat_id`=$sub_category_id";

$main_sql = ($category_id && $sub_category_id) ?
    $fetch_product_sql3 : ($category_id ?
        $fetch_product_sql2 : $fetch_product_sql1);


$prdQuerryResult = $conn->query($main_sql);
$rowCount = $prdQuerryResult->num_rows;
if ($rowCount > 0) {
    while ($productRow = $prdQuerryResult->fetch_assoc()) {

        $prdId = $productRow["prd_id"];
        $prdName = $productRow["prd_name"];
        $prdPrice = $productRow["prd_price"];
        $prdQuantity = $productRow["quantity"];
        $prdImage = $productRow["prd_image"];
        $prdDescription = $productRow["prd_description"];
        $prdCategoryId = $productRow["prd_cat_id"];
        $prdSubCategoryId = $productRow["prd_sub_cat_id"];

        $imgSrc = $prdImage ? "../pipharm-admin-panel/assets/images/product/" . $prdImage : 'assets/img/default.jpg';
        ?>
        <div class="col-md-3 mb-4">
            <!-- hidden inputs -->
            <input type="number" class="d-none" value='<?= $prdQuantity ?>' id='<?= "product_qty_" . $prdId ?>'>


            <div class="card rounded-3" style="width: 100%;height:100%">
                <img src=<?= $imgSrc ?> class="card-img-top" alt="..." onerror="this.src='assets/img/default.jpg'"
                    style="height:200px;">
                <div class="card-body">
                    <h5 class="card-title text-center">
                        <?= $prdName ?>
                    </h5>
                    <p class="text-center"><i class="fa-solid fa-bangladeshi-taka-sign me-1"></i><?=$prdPrice?></p>
                    <?php
                    if ($prdQuantity > 0) {
                        ?>
                        <div>

                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <span type="button" class="btn input-group-addon" onclick="clickDecreasePrdQty('<?= $prdId ?>')"> <i
                                        class="fas fa-minus"></i></span>

                                <input type="text" id=<?= "quantity_" . $prdId ?> class="form-control text-center mx-3" value="1">

                                <span type="button" class="btn input-group-addon" onclick="clickIncreasePrdQty('<?= $prdId ?>','<?= $prdQuantity ?>')"> <i class="fas fa-plus"></i> </span>
                            </div>

                            <a href="#" class="btn btn-primary w-100 rounded-5"
                                onclick='<?php echo "addToCart($prdId,$prdPrice,$userId,$pharmacy_id)" ?>'>Add to
                                Cart
                            </a>
                        </div>
                    <?php } else { ?>
                        <p class="text-center bg-danger text-light rounded p-1">
                            Out of stock
                        </p>
                        <?php

                    }
                    ?>


                </div>
            </div>
         
        </div>
        <?php
    }
} else {
    ?>
    <div class="mt-4">
        <h4 class="text-center">No product found in the selected category.</h4>
    </div>
    <?php
}
?>