<?php
include("../../config/dbConn.php");
session_start();

$userId=isset($_SESSION["loggedInId"]) ? $_SESSION["loggedInId"] : -1;

$pharmacy_id = isset($_POST["shopId"]) ? intval($_POST["shopId"]) : 0;
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : null;


$main_sql = "SELECT * FROM product
WHERE prd_name LIKE '%$searchTerm%' AND pharmacy_id=$pharmacy_id";


$prdQuerryResult = $conn->query($main_sql);
if ($prdQuerryResult) {
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
            <div class="col-md-3">
                <!-- hidden inputs -->
                <input type="number" class="d-none" value='<?= $prdQuantity ?>' id='<?= "product_qty_" . $prdId ?>'>


                <div class="card p-2 rounded-3" style="width: 100%;height:100%">
                    <img src=<?= $imgSrc ?> class="card-img-top" alt="..." onerror="this.src='assets/img/default.jpg'"
                        style="height:200px;">
                    <div class="card-body">
                        <h5 class="card-title text-center">
                            <?= $prdName ?>
                        </h5>
                        <?php
                        if ($prdQuantity > 0) {
                            ?>
                            <div>

                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <span type="button" class="btn input-group-addon" onclick="clickDecreasePrdQty('<?= $prdId ?>')"> <i class="fas fa-minus"></i></span>

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
            <h4 class="text-center">No product found!.</h4>
        </div>
        <?php
    }

} else {
    ?>
    <div class="mt-4">
        <h4 class="text-center"><?=mysqli_error($conn)?></h4>
    </div>
    <?php
}

?>