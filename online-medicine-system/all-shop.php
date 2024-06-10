<!DOCTYPE html>
<html lang="en">
<?php
include('./includes/head.php');
?>

<body class='bg-light-subtle'>
    <section class="d-flex justify-content-center stickyNav" style="background-color:white">
        <section class="navArea position-sticky">
            <?php include('./includes/navbar.php') ?>
        </section>

    </section>
    <section class=" bg-light">

        <div class="container pb-5 pt-4">

            <div class="row">
                <?php
                $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
                $sub_category_id = isset($_GET['sub_category_id']) ? $_GET['sub_category_id'] : null;
                $query1 = "SELECT *
                        FROM pharmacy_admin
                        JOIN pharmacy_address ON pharmacy_admin.id = pharmacy_address.pharmacy_id
                        ";

                $query2 = "SELECT DISTINCT s.*, sa.*
                    FROM pharmacy_admin s
                    INNER JOIN product p ON s.id = p.pharmacy_id
                    INNER JOIN sub_category sc ON p.prd_sub_cat_id = sc.id
                    LEFT JOIN pharmacy_address sa ON s.id = sa.pharmacy_id
                    WHERE sc.category_id = $category_id AND sc.id=$sub_category_id";

                $query3 = "SELECT DISTINCT pa.*, pad.*
                    FROM pharmacy_admin pa
                    INNER JOIN pharmacy_address pad ON pa.id = pad.pharmacy_id
                    INNER JOIN product p ON pa.id = p.pharmacy_id
                    INNER JOIN category c ON p.prd_cat_id = c.id
                    WHERE c.id = $category_id";

                $allShopQuery = '';

                if ($category_id && $sub_category_id) {
                    $allShopQuery = $query2;
                } else if ($category_id) {
                    $allShopQuery = $query3;
                } else {
                    $allShopQuery = $query1;
                }

                $allShopQueryRun = mysqli_query($conn, $allShopQuery);
                $row_count = mysqli_num_rows($allShopQueryRun);
                if ($row_count > 0) {
                    ?>
                    <h3>All Shops</h3>
                    <?php
                    while ($allShopQuery = mysqli_fetch_array($allShopQueryRun)) {
                        $allShopQueryResult = "" . $allShopQuery["id"] . "" . $allShopQuery["first_name"] . "" . $allShopQuery["last_name"] . " " . $allShopQuery["shop_name"] . " " . $allShopQuery["admin_email"];
                        $shopId = $allShopQuery["id"];
                        $shopName = $allShopQuery["shop_name"];
                        $shopImage = $allShopQuery["shop_image"];
                        $shopRating = $allShopQuery["rating"];
                        $address = $allShopQuery["address"] . ", " . $allShopQuery["city"];

                        $imgSrc = $shopImage ? "../pipharm-admin-panel/assets/images/store/banner/" . $shopImage : "assets/img/shop/pharmacy.png";

                        ?>
                        <div class="col-md-3 col-xs-12 pt-4">

                            <div class="card shadow rounded-4" style="width:95%;">
                                <div class="p-3" style="background-color:#f2f2f2;">
                                    <img src=<?= $imgSrc ?> class="card-img-top" style="height:180px;" alt="..."
                                        onerror="this.src='assets/img/default.jpg'">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title text-center">
                                        <?= ucwords($shopName) ?>
                                    </h5>
                                    <div>
                                        <div class="my-1">
                                            <p class="text-center">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    ?>
                                                    <i class="fa-regular fa-star"></i>
                                                    <?php
                                                }

                                                ?>

                                            </p>
                                            <div class="d-flex align-items-center" style="height:50px">
                                                <div class="p-2 border me-2 rounded"><i class="fa-solid fa-location-dot "></i>
                                                </div>
                                                <small>
                                                    <?= $address ?>
                                                </small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-center border-top">
                                        <a href=<?php echo "shop.php?id=" . $shopId; ?> style="color:#022314">Visit <i
                                                class="fa-solid fa-arrow-right ps-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div style="min-height:52vh" class="d-flex justify-content-center align-items-center">
                        <div>
                            <div class="text-center mb-2">
                                <img src="assets/img/empty-folder.png" class="img-fluid" style="width:150px"
                                    alt="Responsive image">
                            </div>
                            <h5 class="text-center mb-4">No Shops Data found!</h5>
                            <a href="all-shop.php">
                                <button type="button" class="btn btn-primary ">Go To All Shops Page <i
                                        class="fa-solid fa-arrow-right ms-1"></i></button>
                            </a>
                        </div>

                    </div>
                    <?php
                }

                ?>
            </div>
        </div>


    </section>
    <footer>
        <?php include("./includes/footer.php") ?>
    </footer>
</body>

</html>